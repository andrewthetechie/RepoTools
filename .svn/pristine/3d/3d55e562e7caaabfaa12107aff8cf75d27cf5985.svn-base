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

		
	if(isset($_POST['action']))
	{
		switch($_POST['action'])
		{
			case 'add':
			default:
				$groups = listGroups();
				if(in_array(clean($_POST['groupName']),$groups))
				{		
					echo "<h3><font color='red'>Group";
					echo " already exists. Please try ";
					echo "another name</font></h3>";	
				}
				else
				{
					addGroup(clean($_POST['groupName']));	
					echo "<h3><font color='green'>Group ";
					echo "added. </font></h3>";

				}
				break;

			case 'delete':
				deleteGroup(clean($_POST['groupName']));
				echo "<h3><font color='blue'>Group ";
				echo "deleted </font></h3>";
				break;

		}

	}

?>


		<form name="addGroup" action="addGroup.php" method="POST" 
			class="form-horizontal">
			<input type="hidden" name="action" value="add" />
		<fieldset>
		<!-- Form Name -->
		<legend>Add Group</legend>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="groupName">Group Name</label>
		  <div class="controls">
			<input id="groupName" name="groupName" placeholder="NewGroupName" 
				class="input-xlarge" required="" type="text">
			<p class="help-block">No spaces or special characters</p>
		  </div>
		</div>

		<!-- Button -->
		<div class="control-group">
		  <label class="control-label" for="submit"></label>
		  <div class="controls">
			<button id="submit" name="submit" 
				class="btn btn-primary">Create New Group</button>
		  </div>
		</div>

		</fieldset>
		</form>


		<br /><hr />
		<form name="deleteGroup" action="addGroup.php" method="POST" 
			class="form-horizontal">
			<input type="hidden" name="action" value="delete" />
		<fieldset>

		<!-- Form Name -->
		<legend>Delete Group</legend>

		<!-- Select Basic -->
		<div class="control-group">
		  <label class="control-label" for="groupName">Group To Delete:</label>
		  <div class="controls">
			<select id="groupName" name="groupName" class="input-large">
				<?php 
					$groups = listGroups();
					
					for($i=0; $i<count($groups); $i++)
					{
						$group = $groups[$i];
						echo "<option value='$group'>$group</option>";
					}
				?>
			</select>
		  </div>
		</div>

		<!-- Button -->
		<div class="control-group">
		  <label class="control-label" for="submit"></label>
		  <div class="controls">
			<button id="submit" name="submit" 
				class="btn btn-danger">Delete Group</button>
		  </div>
		</div>

		</fieldset>
		</form>

	</div>
</body>
</html>
