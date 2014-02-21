<?php
	include("config.php");


	//*******************User Functions********************
        //Functions that work with users
	function addUser($user,$pass,$isAdmin)
	{
		$user = inputCleaner($user);
		$isAdmin = inputCleaner($isAdmin);
		
		$query = "INSERT INTO users (id, username, 
			password, admin) VALUES (NULL, '$user', 
			'$pass', '$isAdmin');"; 

		dbQuery($query);	
		rebuildConfFiles("users");
	}

	function deleteUser($user)
	{
		$user=inputCleaner($user);
		$query = "select id from users where username='$user'";
		$result = dbQueryArray($query);
		$userID = $result[0]['id'];

		$query = "select id,members from groups where members LIKE '%$userID%'";
		$groups = dbQueryArray($query);
		
		for($i=0; $i<count($groups); $i++)
		{	
			$current = $groups[$i];
			$members = explode(",",$current['members']);
			for($x=0; $x<count($members); $x++)
			{	
				if($members[$x] == $userID)
					unset($members[$x]);
			}
			$members = implode(",", $members);
			updateGroupMembership($current['id'],$members);
		}	
			
		$query = "delete from users where username='$user'";
		dbQuery($query);

		rebuildConfFiles("both");

	}	
	
	function getUserList()
	{
		$query = "select id,username from users order by username";
		$array= dbQueryArray($query);
		$userList = array();

		for($i=0; $i<count($array); $i++)
		{	
			$userList[$i]['name'] = $array[$i]['username'];
			$userList[$i]['id'] = $array[$i]['id'];
		}
		return $userList;

	}

	function getUserLookupTable()
	{
		$query = "select id,username from users";
		$array = dbQueryArray($query);
		$lookupTable = array();
		for($i=0; $i < count($array); $i++)
		{
			$current = $array[$i];
			$lookupTable[$current['id']] = $current['username'];	
		}
		return $lookupTable;
	}
	
	function createPassword($string)
	{
		return crypt($string, base64_encode($string));
	}
		
	function changePassword($user,$pass)
	{
		$pass = createPassword($pass);
		$query = "update users set password='$pass' where ";
		$query .= "username='$user'";
		dbQuery($query);
		rebuildConfFiles("users");
	}


	//*******************Group Functions********************
        //Functions that work with group
	function addGroup($name)
	{
		$query = "INSERT INTO groups ";
		$query .= "(id, name, members) VALUES ";
		$query .= "(NULL, '$name', NULL);";
		dbQuery($query);
		
		$groupId = groupNameToId($name);
		$repos = listAllRepos();
		//loop through all repos to remove the permission entries
		//for this group
		for($i=0;$i<count($repos);$i++)
		{
			setRepoPerms($repos[$i],$groupId,"0");	
		}
		
	}

	function deleteGroup($name)
	{
		$groupId = groupNameToId($name);
		$repos = listAllRepos();
		//loop through all repos to remove the permission entries
		//for this group
		for($i=0;$i<count($repos);$i++)
		{
			deleteRepoPerms($repos[$i],$groupId);	
		}
		
		$query = "delete from groups where name='$name'";
		dbQuery($query);
		rebuildConfFiles("perms");
	}

	function updateGroupMembership($id,$members)
	{	
		$query = "update groups set members='$members' where id=$id";
		dbQuery($query);
		rebuildConfFiles("perms");
				
	}

	function getGroupMembership($groupName)
	{	
		$query = "select members from groups where name='$groupName'";
		$result = dbQueryArray($query);
		$members = $result[0][0];
		if($members != NULL)
			$toReturn = explode(",",$members);
		else
			$toReturn = array();
		return $toReturn;		
	}
	
	function listGroups()
	{
		$query = "select name from groups order by name";
		$array = dbQueryArray($query);
		$groups = array();
		for($i=0; $i<count($array); $i++)
		{		
			$groups[$i] = $array[$i][0];
		}
		return $groups;
	}
	
	function getGroupLookupTable()
	{
		$query = "select id,name from groups";
		$array = dbQueryArray($query);
		$lookupTable = array();
		for($i=0; $i < count($array); $i++)
		{
			$current = $array[$i];
			$lookupTable[$current['id']] = $current['name'];	
		}
		return $lookupTable;
	}
	

	function addMemberToGroup($userid,$groupName)
	{
		$members = getGroupMembership($groupName);
		array_push($members,$userid);
		$memberString = implode(",",$members);
		
		$query = "update groups set members='$memberString' where";
		$query .= " name='$groupName'";
		
		dbQuery($query);
		rebuildConfFiles("perms");
	}
	
	
	function deleteMemberFromGroup($userid,$groupName)
	{
		$members = getGroupMembership($groupName);
		$newMembers = array();
		for($i=0; $i<count($members); $i++)
		{
			if($members[$i] != $userid)
				array_push($newMembers,$members[$i]);
		}	
		$memberString = implode(",",$newMembers);
		$query = "update groups set members='$memberString' where";
		$query .= " name='$groupName'";
		
		dbQuery($query);
		rebuildConfFiles("perms");
	}

	//returns a group name for a given id
	function groupIdToName($groupId)
	{	
		$query = "select name from groups where id=$groupId";
		$array = dbQueryArray($query);
		return $array[0]['name'];
	}

	//returns an id when given a group name
	function groupNameToId($groupName)
	{
		$query = "select id from groups where name='$groupName'";
		$array = dbQueryArray($query);
		return $array[0]['id'];
	}
	
	function getGroupNameToIdTable()
	{
		$query = "select name,id from groups";
		$array = dbQueryArray($query);
		$lookupTable = array();
		for($i=0; $i < count($array); $i++)
		{
			$current = $array[$i];
			$lookupTable[$current['name']] = $current['id'];	
		}
		return $lookupTable;
	}

	//*******************Repo Functions********************
        //Functions for managing Repos.
	
	//adds a new repo named $repoName
	function addRepo($repoName)
	{
		$permString = blankRepoPermissions();
		$query = "insert into repos ";
		$query .= "(`id`, `name`, `groupPerms`, `deleted`, `archived`)";
		$query .= " VALUES (NULL, '$repoName', '$permString', '0', '0');";
		dbQuery($query);
		addRepoFileSystem($repoName);
		
	}

	//creates the directory for the repo using svnadmin and
	//sets the appropriate permissions
	//requires repoName
	function addRepoFileSystem($repoName)
	{
		$cmd = 'svnadmin create ';
		$pathString = SVNFILEPATH . DIRECTORY_SEPARATOR . $repoName;
		$cmd .= escapeshellarg($pathString);
                exec('sudo ' . $cmd, $output, $exitValue);
                if ($exitValue != 0)
                {
                    // put the error message on the session, redirect out
                }


                $cmd = 'chown -R www-data:www-data ';
		$pathString = SVNFILEPATH . DIRECTORY_SEPARATOR . $repoName;
		$cmd .= escapeshellarg($pathString);

                exec('sudo ' . $cmd, $output, $exitValue);
                $cmd = 'chmod -R g+ws '; 
		$pathString = SVNFILEPATH . DIRECTORY_SEPARATOR . $repoName;
		$cmd .= escapeshellarg($pathString);

                exec('sudo ' . $cmd, $output, $exitValue);

	}

	//builds a blank permission string for a new repo
	//returns the json encoded string to go in the permissions
	function blankRepoPermissions()
	{
		$query = "select id from groups";
		$result = dbQueryArray($query);
		$permArray=array();
		for($i=0; $i<count($result); $i++)
		{	
			$permArray[$result[$i][0]] = "0";
		}

		return json_encode($permArray);

	}
	//sets repo to deleted in database so archiver can archive it
	//later as cron job
	function deleteRepo($repoName)
	{
		$query = "update repos set deleted=1 where name='$repoName'";
		dbQuery($query);
		rebuildConfFiles("perms");
	}

	//restores a repo, if archived the restore cron job will restore it later
	function restoreRepo($repoName)
	{
		$query = "update repos set deleted=0 where name='$repoName'";
		dbQuery($query);
		rebuildConfFiles("perms");
	}

	//Returns an array of all repos
	function listRepos()
	{
		$query = "select name from repos where deleted=0";
		$query.= " and archived=0 order by name";
		$array= dbQueryArray($query);
		$repoNames=array();
		for($i=0;$i<count($array);$i++)
		{
			$repoNames[$i] = $array[$i]['name'];
		}
		return $repoNames;
	}

	//Returns an array of all deletedrepos
	function listDeletedRepos()
	{
		$query = "select name from repos where deleted=1 order by name";
		$array= dbQueryArray($query);
		$repoNames=array();
		for($i=0;$i<count($array);$i++)
		{
			$repoNames[$i] = $array[$i]['name'];
		}
		return $repoNames;
	}


	//retunrs an array of all repos - deleted and active
	function listAllRepos()
	{
		$query = "select name from repos order by name";
		$array= dbQueryArray($query);
		$repoNames=array();
		for($i=0;$i<count($array);$i++)
		{
			$repoNames[$i] = $array[$i]['name'];
		}
		return $repoNames;
	}

	//returns the first repo to be archived that is not already being
	//worked on
	function getRepoToArchive()
	{
		$query = "select name from repos where deleted=1 and ";
		$query .= "archived=0 and beingProcessed=0 limit 1";
		$result = dbQueryArray($query);
		$name=NULL;
		if(count($result)>0)
			$name = $result[0]['name'];

		return $name;
	}

	//returns the first repo to be restored that is not already being
	//worked on
	function getRepoToRestore()
	{
		$query = "select name from repos where deleted=0 and ";
		$query .= "archived=1 and beingProcessed=0 limit 1";
		$result = dbQueryArray($query);
		$name=NULL;
		if(count($result)>0)
			$name = $result[0]['name'];

		return $name;

	} 

	//sets a repo as being processed
	function setBeingProcessed($repoName)
	{
		$query = "update repos set beingProcessed=1 where ";
		$query .="name='$repoName'";
		dbQuery($query);
	}

	//clears being processed flag
	function clearBeingProcessed($repoName)
	{
		$query = "update repos set beingProcessed=0 where ";
		$query .="name='$repoName'";
		dbQuery($query);

	}

	//returns true is a repo already exists
	function repoExists($repoName)
	{
		$query = "select id from repos where name='$repoName'";
		$result = dbQueryArray($query);
		return count($result);
	}
	
	//Returns an arrya of repo permissions from a reponame
	function getRepoPerms($repoName)
	{	
		$query = "select groupPerms from repos where name='$repoName'";
		$array = dbQueryArray($query);
		return json_decode($array[0]['groupPerms'],true);
	}

	//sets permissions for a group on a repo
	function setRepoPerms($repoName,$groupId,$perms)
	{	
		$currentPerms = getRepoPerms($repoName);
		$currentPerms[$groupId] = $perms;
		$encodedPerms = json_encode($currentPerms);
		
		$query = "update repos set groupPerms='$encodedPerms' ";
		$query .= "where name='$repoName'";
		dbQuery($query);
		rebuildConfFiles("perms");
		
	}
	//deletes a group from the permissions on a repo
	//mainly used when deleting a group
	function deleteRepoPerms($repoName,$groupId)
	{
		$currentPerms = getRepoPerms($repoName);
		unset($currentPerms[$groupId]);

		$encodedPerms = json_encode($currentPerms);
		
		$query = "update repos set groupPerms='$encodedPerms' ";
		$query .= "where name='$repoName'";
		dbQuery($query);

	}

	//dumps a repo to a file
	//returns the path to the .dump file, takes reponame as argument
	function dumpRepo($repoName)
	{
		$repoPath = SVNFILEPATH . DIRECTORY_SEPARATOR .$repoName;
		$dumpPath = TEMPPATH . DIRECTORY_SEPARATOR . $repoName.".dump";

		$cmd = 'svnadmin dump -q '; 
			$cmd .= escapeshellarg($repoPath);
			$cmd .= "> " . $dumpPath;
		
		exec('sudo ' . $cmd, $output, $exitValue);  		

		return $dumpPath;
	}

	//turns an archive dump into an archive
	//takes repoName, path of dump and archive type as an argument
	//moves archive to archive location and returns path to archive file
	function archiveDump($repoName,$dumpFile,$archiveType)
	{
		$archiveFile = SVNARCHIVEPATH . DIRECTORY_SEPARATOR .$repoName;

		switch ($archiveType)
		{
			case 'zip':
				$archiveFile .= ".zip";	
				$zip = new ZipArchive;
				$res = $zip->open($archiveFile, 
					ZipArchive::CREATE);
				$zip->addFile($dumpFile);
				$zip->close();
				break;

			case 'targz':
			default: 				
				$archiveFile .= ".gz";
				$fp = gzopen($archiveFile,'w9');
				gzwrite($fp,file_get_contents($dumpFile));
				gzclose($fp);
				break;

		}
		
		//makes sure the file exists and has a filesize
		if(!(file_exists($archiveFile) && filesize($archiveFile) ))
			$archiveFile == NULL;

		//if the file exists and isnt null, assume the compression was
		//successful and delete the originals.
		if($archiveFile != NULL)
		{
			deleteDump($dumpFile);
			$deletionSuccess = deleteRepoFiles($repoName);
		}	
		
		//will return null if failed. Use null to make sure to
		//report an error and rerun process.

		if($deletionSuccess && $archiveFile != NULL)
		{
			$query = "update repos set archived=1 ";
			$query .= "where name='$repoName'";
			dbQuery($query);
			clearBeingProcessed($repoName);	

		}
		return $archiveFile;
		
	}


	//deletes a dump file after it has been successfully archived
	//takes dump file name (full path) as an argument
	//returns true if deletion successful
	function deleteDump($dumpFile)
	{
		return unlink($dumpFile);
	}


	//deletes the files for a repo under SVNFILEPATH
	//takes repoName as an argument
	//returns true if deletion successful
	function deleteRepoFiles($repoName)
	{
		$repoPath = SVNFILEPATH.DIRECTORY_SEPARATOR.$repoName;

		$result = rmdir($repoPath);
		if(!$result)
		{ 
			$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($repoPath, 
				RecursiveDirectoryIterator::SKIP_DOTS),
   			 RecursiveIteratorIterator::CHILD_FIRST
			);

			foreach ($files as $fileinfo) {
				$todo = ($fileinfo->isDir() ? 'rmdir':'unlink');
				$todo($fileinfo->getRealPath());
		
			}
			
			$result = rmdir($repoPath);	
		}
		return $result; 

	}

	//Decompresses an archive of a repo dump to the temp directory
	//for restoration
	//takes repo name as an argument
	//returns file (full path) of dump file
	function decompressRepoArchive($repoName,$archiveType)
	{
		$archiveFile = SVNARCHIVEPATH . DIRECTORY_SEPARATOR .$repoName;
		$dumpFile = TEMPPATH . DIRECTORY_SEPARATOR. $repoName .".dump";
 
		switch($archiveType)
		{
			case "targz":
			default:
				$archiveFile .= ".gz";
				$sfp = gzopen($archiveFile, "rb");
				$fp = fopen($dumpFile,"w");
				while($string=gzread($sfp,4096))
				{
					fwrite($fp,$string,strlen($string));
				}	
				gzclose($sfp);
				fclose($fp);
				break;

			case "zip":
				$archiveFile .= ".zip";
				$zip = new ZipArchive;
    				if ( $zip->open( $archiveFile ) )
    				{
			        for ( $i=0; $i < $zip->numFiles; $i++ )
			        {
					$entry = $zip->getNameIndex($i); 
					// skip directories
					if ( substr( $entry, -1 ) == '/' ) 
						continue;
					$fp = $zip->getStream( $entry );
					$ofp = fopen($dumpFile ,'w' );
          				while ( ! feof( $fp ) )
						fwrite( $ofp, fread($fp, 8192));
           
					fclose($fp);
					fclose($ofp);
				}
				$zip->close();
				}
				else
					return false;
				break;
		}

		
		return $dumpFile;
	
	}

	//imports a svn dump to a repo
	//needs repoName and dumpFile path
	function importRepoDump($repoName,$dumpFile)
	{
		$cmd = 'svnadmin load ';
		$pathString = SVNFILEPATH . DIRECTORY_SEPARATOR . $repoName;
		$cmd .= escapeshellarg($pathString) ." < ";
		$cmd .= escapeshellarg($dumpFile);
                exec('sudo ' . $cmd, $output, $exitValue);
                if ($exitValue == 0)
                {
			unlink($dumpFile);
			$query = "update repos set archived=0 where "; 
			$query.= "name='$repoName'";
			dbQuery($query);
			clearBeingProcessed($repoName);
                }
		
	}

	//gets percentage disk space used for the directory passed to it
	//Argument
	//$dir - directory to check
	function percentageFreeDiskSpace($dir)
	{            
		$freeSpace = disk_free_space($dir);

		$totalSpace = disk_total_space($dir);

		$percentageFree = round($freeSpace/$totalSpace,2)* 100;

		return $percentageFree;
	}
	
	//*******************File Functions********************
        //Rebuilds the configuration files for svn passwords and 
	//svn permissions

	function rebuildConfFiles($which)
	{
		switch($which)
		{
			case "users":
				//rebuild the SVN passwd file
				$query = "select username,password from users";
				$users = dbQueryArray($query);

				$svnPasswdString = "";
				for($i=0;$i<count($users);$i++)
				{
					$user = $users[$i]['username'];
					$pass = $users[$i]['password'];
					$svnPasswdString.=$user.":".$pass.PHP_EOL;
				}
				$file = SVNCONFPATH . DIRECTORY_SEPARATOR;
				$file .= SVNPASSWDFILE;
				file_put_contents($file,$svnPasswdString);
				break;

			case "perms":
				//rebuild the permissions file
				$groups = listGroups();
				$repos = listRepos();
				$userLookup = getUserLookupTable();
				$groupLookup = getGroupLookupTable();
				$svnPermString = "";
				$svnPermString .= "[groups]" .PHP_EOL;
				for($i=0; $i<count($groups); $i++)
				{
					$group = $groups[$i];
					$members = getGroupMembership($group);
					$svnPermString .= "$group = ";
					for($x=0;$x<count($members); $x++)
					{
						$user = 
						$userLookup[$members[$x]];
						
						if($x != count($members) -1)
						{
						$svnPermString .= "$user,"; 
						}
						else
						{
						$svnPermString .="$user";	
						}
					}
					$svnPermString .= PHP_EOL;
				}
				
				$svnPermString .= PHP_EOL;
				
				for($i=0; $i<count($repos); $i++)
				{
					$repo = $repos[$i];
					$perms = getRepoPerms($repo);
					$svnPermString .= "[$repo:/]".PHP_EOL;
					for($x=0;$x<count($groups);$x++)
					{
						$group = $groups[$x];
						$groupId = 
							groupNameToId($group);
						switch($perms[$groupId])
						{
						case 'r':
						$svnPermString .= "@$group = ";
						$svnPermString .= "r" .PHP_EOL;
						break;

						case 'w':
						$svnPermString .= "@$group = ";
						$svnPermString .= "rw".PHP_EOL;
						break;
			
						case '0':
						default:
						$svnPermString .= "@$group = ";
						$svnPermString .= PHP_EOL;
						break;
						}				
					
					}
					$svnPermString .= PHP_EOL;
					
				}
				$file = SVNCONFPATH . DIRECTORY_SEPARATOR;
				$file .= SVNPERMFILE;
				file_put_contents($file,$svnPermString);
				break;

			case "both":
			default:
				rebuildConfFiles("users");
				rebuildConfFiles("perms");
				break;
			
		}

	}


	//*******************Database Functions********************
        //connects to the database and performs a database query
        function dbQuery($query)
        {
                mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
                mysql_select_db(DB_NAME) or die(mysql_error());

                $result = mysql_query($query);
                        if (!$result) {
                                die('Could not query:' . mysql_error());
                        }
                mysql_close();
                return $result;
        }	
	
	//returns the result of $query as an array)
	function dbQueryArray($query)
	{
                mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
                mysql_select_db(DB_NAME) or die(mysql_error());

                $result = mysql_query($query);
                        if (!$result) {
                                die('Could not query:' . mysql_error());
                        }
		$array = array();
		for($i=0;$row = mysql_fetch_array($result);$i++)
		{	
			$array[$i] = $row;
		}	

                mysql_close();
                return $array;

	}

        //Check if magic qoutes is on then stripslashes if needed
        function inputCleaner($var)
        {
                mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
                mysql_select_db(DB_NAME) or die(mysql_error());
                if (is_array($var)) {
                        foreach($var as $key => $val) {
                                $output[$key] = inputCleaner($val);
                        }
                } else {
                        $var = strip_tags(trim($var));
                        if (function_exists("get_magic_quotes_gpc")) {
                                $output = mysql_real_escape_string((get_magic_quotes_gpc())? stripslashes($var): $var);
                        } else {
                        $output = mysql_real_escape_string($var);
                        }
                }
                if (!empty($output))
                        return $output;
                mysql_close();
        }

	//cleans a string by replacing all spaces with a - and removes all
	//special chars
	function clean($string) {
		// Replaces all spaces with hyphens.
		$string = str_replace(" ", "-", $string); 
		// Removes special chars.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
		// Replaces multiple hyphens with single one.
		return preg_replace('/-+/', '-', $string); 
	}

?>
