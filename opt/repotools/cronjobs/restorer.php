<?php

if(php_sapi_name() == 'cli' || empty($_SERVER['REMOTE_ADDR'])) {
	$basePath = explode("/",$_SERVER['PHP_SELF']);
	array_pop($basePath);
	$basePath = implode("/",$basePath);
	
	include($basePath . "/../includes/php/functions.php");

	$repo = getRepoToRestore();

	if($repo == NULL)
	{
		//nothing to do so die
		exit();
	}
	
	//from this point on, we have a repo to work on
	
	//set the repo to being processed so no other worker grabs it
	setBeingProcessed($repo);

	addRepoFileSystem($repo);
	
	$dumpFile = decompressRepoArchive($repo,ARCHIVE_TYPE);

	importRepoDump($repo,$dumpFile);
 	

} else {
	//being run in the webserver is no bueno
	die();
}

?>
