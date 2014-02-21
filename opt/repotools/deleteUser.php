<?php
        if($_SERVER['REMOTE_ADDR']!="71.40.14.2")
        {
//                exit();
        }

	session_start();
	//set default user status
	$userStatus = false;

	if ( isset($_SESSION['username']) && isset($_SESSION['password']) 
		&& $_SESSION['isAdmin'] == 1)
	{

		$userStatus = true;

	}//end of user is logged in


	if(!$userStatus){
		header("Location: logout.php");
		exit();
	}
	include('includes/functions.php');

	if(isset($_POST['userName'])) 
	{
		deleteUser($_POST['userName']);
		echo "<h3>Deleted " . $_POST['userName'];
		echo "<br /><a href='index.php'>Home</a>";	


	}
	else{

?>

<html>

<body>
	<form name="deleteSVNUser" action="deleteUser.php" method="POST">
		<label for="userName">Username:
		<input type="text" name="userName" />
		<br />
		<br />	
		<input type="Submit" value="Delete User"/>
	</form>

</body>

</html>

<?php

	}

	function clean($string) {
		$string = str_replace(" ", "-", $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}	
?>
