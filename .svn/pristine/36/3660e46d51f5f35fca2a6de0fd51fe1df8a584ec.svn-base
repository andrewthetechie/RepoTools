<?php
	include('includes/php/header.php');

	if(!$userStatus){
		header("Location: logout.php");
		exit();
	}
	if($_SESSION['isAdmin'] != 1)
	{
		header("Location: logout.php");
		exit();
	}
	

	include('includes/php/htmlHeader.php');
	?>
	<body>
	<div class="container">
	
	<?php include('includes/php/navbar.php'); 
	
	if((isset($_POST['userName']) && isset($_POST['action']) 
		&& isset($_POST['password'])) 
		|| (isset($_POST['userName']) && $_POST['action'] === "delete"))
	{
			switch($_POST['action'])
			{

				case 'add':
				$user = clean($_POST['userName']);
				$pass = createPassword($_POST['password']);
			
				$isAdmin=0;
				if($_POST['permissionLevel'] === "admin")
					$isAdmin=1;

	
				addUser($user,$pass,$isAdmin);			
	
				echo "<h3>Created new user $user</h3>";
				break;

				case 'delete':
				deleteUser($_POST['userName']);
				echo "<h3>User deleted</h3>";
				break;

				default:
				echo "<h3>Some sort of error occurred</h3>";
				break;

			}
	}


?>


	<form name="addSVNUser" action="addUser.php" method="POST" 
		class="form-horizontal">
		<input type="hidden" name="action" value="add" />
		<fieldset>

		<!-- Form Name -->
		<legend>Add A User</legend>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="userName">UserName</label>
		  <div class="controls">
			<input id="username" name="userName" placeholder="username" 
				class="input-large" required="" type="text">
			<p class="help-block">No spaces or special characters</p>
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="password">Password</label>
		  <div class="controls">
			<input id="password" name="password" placeholder="password" 
				class="input-large" required="" type="text">
			
		  </div>
		</div>

		<!-- Select Basic -->
		<div class="control-group">
		  <label class="control-label" 
			for="permissionLevel">Permission Level</label>
		  <div class="controls">
			<select id="permissionLevel" name="permissionLevel" 
				="input-large">
			  <option value="user">User</option>
			  <option value="admin">Admin</option>
			</select>
		  </div>
		</div>

		<!-- Button -->
		<div class="control-group">
		  <label class="control-label" for="submit"></label>
		  <div class="controls">
			<button id="submit" name="submit" 
				class="btn btn-success">Add User</button>
		  </div>
		</div>

		</fieldset>
	</form>

	
	<form name="deleteSVNUser" action="addUser.php" method="POST" 
		class="form-horizontal">
		<input type="hidden" name="action" value="delete" />
	<fieldset>

	<!-- Form Name -->
	<legend>Delete A User</legend>

	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="userName">User Name</label>
	  <div class="controls">
		<select id="username" name="userName" class="input-large">
			<?php
				$users = getUserList();
				for($i=0; $i<count($users); $i++)
				{
					$name = $users[$i]['name'];
					echo "<option value='$name'>$name</option>";
				}
			?>
		</select>
	  </div>
	</div>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="submit"></label>
	  <div class="controls">
		<button id="submit" name="submit" class="btn btn-danger">Delete User</button>
	  </div>
	</div>

	</fieldset>
	</form>


</body>

</html>
