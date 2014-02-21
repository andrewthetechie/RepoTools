<?php
	include("includes/php/functions.php");

	for($i=0;$i<count($toImport);$i++)
	{
		$repoName = $toImport[$i];
		$groupID = 1;
		$perms = "w";
		$permString = blankRepoPermissions();

		$query = "insert into repos ";
		$query .= "(`id`, `name`, `groupPerms`, `deleted`, `archived`)";
		$query .= " VALUES (NULL, '$repoName', '$permString', '0', '0');";
		dbQuery($query);
		
		$currentPerms = getRepoPerms($repoName);
		$currentPerms[$groupId] = $perms;
		$encodedPerms = json_encode($currentPerms);
		
		$query = "update repos set groupPerms='$encodedPerms' ";
		$query .= "where name='$repoName'";
		dbQuery($query);

	}	

	rebuildConfFiles("both");

	
?>
