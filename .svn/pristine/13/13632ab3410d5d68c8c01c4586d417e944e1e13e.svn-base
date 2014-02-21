<?php
	include("includes/php/functions.php");

	session_start();//need to start our session first, of course


	//check if any login data has been posted our way
	if ( !empty($_POST['username']) && !empty($_POST['password']) )
	{

		//assign input data to temp vars
		$username = $_POST['username'];
		$password = createPassword($_POST['password']);

		$query = "select count(id)i,admin from users where username='$username'";
		$query .= " and password='$password'";

                mysql_connect(DB_SERVER,DB_USER,DB_PASS);

                mysql_select_db(DB_NAME);
                $result = mysql_query($query) or die(mysql_error());
                $row= mysql_fetch_array($result);
		//login is correct, username and pw match, user is an admin
		if($row[0] == 1)
		{
			//time to set sessions and stuff
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['isAdmin'] = $row['admin'];

			//send the redirect header
			header('Location: index.php');
			exit();

		}//end of login is correct
		else{
			//login is bad, either role doesnt match or invalid 
			//username and password
			header('Location: index.php?status=Invalid');
			exit();
		}


	}//end of login data has been sent
	else{ //no login data sent, send back to login form
		header('Location: index.php');
	}
?>
