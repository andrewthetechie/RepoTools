<?php
	include('includes/php/header.php');


	if(!$userStatus){
		header("Location: logout.php");
		exit();
	}
	
		include('includes/php/htmlHeader.php');
	?>
	<body>
	<div class="container">
	
	<?php include('includes/php/navbar.php'); 


	if(isset($_POST['newPassword']) && isset($_POST['confirmPassword']))
	{

		if($_POST['newPassword'] != $_POST['confirmPassword'])
		{
			echo "<h3><font color ='red'>Passwords did not match."; 
			echo "Please try again</font></h3>";

		}
		else
		{
			if(isset($_POST['username']))
			{
				$user = $_POST['username'];
			}
			else
			{
				$user = $_SESSION['username'];
			}
			changePassword($user,$_POST['newPassword']);
			echo "<h3><font color='green'>Password reset for ";
			echo "$user </font></h3>";
		}
		
		
	}
?>

	<h3>Change your password</h3>
	<form name="changePassword" action="changePassword.php" method="POST"
		class="form-horizontal">
	<fieldset>

	<!-- Form Name -->
	<legend>Change Your Password</legend>

	<!-- Password input-->
	<div class="control-group">
	  <label class="control-label" for="newPassword">Password </label>
	  <div class="controls">
		<input id="newPassword" name="newPassword" placeholder="***********" class="input-large" required="" type="password">
		
	  </div>
	</div>

	<!-- Password input-->
	<div class="control-group">
	  <label class="control-label" for="confirmPassword">Confirm Password</label>
	  <div class="controls">
		<input id="confirmPassword" name="confirmPassword" placeholder="***********" class="input-large" required="" type="password">
		
	  </div>
	</div>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="submit"></label>
	  <div class="controls">
		<button id="submit" name="submit" class="btn btn-success">Change Password</button>
	  </div>
	</div>

	</fieldset>
	</form>


	<?php
		if($_SESSION['isAdmin'] == 1)
		{	
	?>
		<h3> Change another user's Password </h3>
		<form name="changeOtherPassword" action="changePassword.php" 
			method="POST" class="form-horizontal">
		<fieldset>

		<!-- Form Name -->
		<legend>Change Another User's Password</legend>

		<!-- Select Basic -->
		<div class="control-group">
		  <label class="control-label" for="username">User To Change</label>
		  <div class="controls">
			<select id="username" name="username" class="input-large">
			<?php
				$users = getUserList();
				for($i=0;$i<count($users);$i++)
				{
					$user = $users[$i]['name'];
					echo "<option value='$user'>$user</option>";
				}
			?>
			</select>
		  </div>
		</div>

		<!-- Password input-->
		<div class="control-group">
		  <label class="control-label" for="newPassword">Password </label>
		  <div class="controls">
			<input id="newPassword" name="newPassword" placeholder="***********" class="input-large" required="" type="password">
			
		  </div>
		</div>

		<!-- Password input-->
		<div class="control-group">
		  <label class="control-label" for="confirmPassword">Confirm Password</label>
		  <div class="controls">
			<input id="confirmPassword" name="confirmPassword" placeholder="***********" class="input-large" required="" type="password">
			
		  </div>
		</div>

		<!-- Button -->
		<div class="control-group">
		  <label class="control-label" for="submit"></label>
		  <div class="controls">
			<button id="submit" name="submit" class="btn btn-success">Change Password</button>
		  </div>
		</div>

		</fieldset>
		</form>

	<?php

		}
	?>

</body>
<?php include('includes/php/footer.php'); ?>
