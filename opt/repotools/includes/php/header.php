<?php


	if($_SERVER['REMOTE_ADDR']!="71.40.14.2")
        {
//                exit();
        }

	session_start();//resume your session (if there is one) or start a new one
	include('includes/php/functions.php');
	
	if(isset($_GET['status']))
	{
		switch($_GET['status'])
		{
			case 'Invalid':
				$status="Invalid Login";
				break;

			case 'notLogged':
				$status="You must be logged in";
				break;
			
			default:
				$status="";
				break;
		}

	}
	//set default user status
	$userStatus = false;

	if ( isset($_SESSION['username']) && isset($_SESSION['password']) )
	{

		$userStatus = true;

	}//end of user is logged in

	
?>