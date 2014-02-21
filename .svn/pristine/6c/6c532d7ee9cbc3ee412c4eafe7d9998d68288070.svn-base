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
		$userid = $_POST['userid'];
		$groupName = $_POST['groupName'];
		switch($_POST['action'])
		{
			case 'addMember':
			addMemberToGroup($userid,$groupName);
			echo "<h3><font color='green'>User added to ";
			echo "group</font></h3>";
			break;

			case 'deleteMember':
			deleteMemberFromGroup($userid,$groupName);
			echo "<h3><font color='red'>User deleted from ";
			echo "group</font></h3>";
			break;

			default:
			echo "<h3><font color='red'>Some error has occured.";
			echo " Please try your request again</font></h3>";
			break;
		}
	}


	$groups = listGroups();
	$users = getUserList();
	$userLookup = getUserLookupTable();
?>



	<?
		for($i=0; $i<count($groups); $i++)
		{
			echo "<h3>" . $groups[$i] . "</h3>";
			?>
			<form action='editGroup.php' method='POST'
				class="form-horizontal">
			<input type="hidden" name="groupName"
				value="<?echo $groups[$i];?>" />
			<input type="hidden" name="action" value="addMember" />
			<fieldset>

			<!-- Form Name -->
			<legend>Add Member</legend>

			<!-- Select Basic -->
			<div class="control-group">
			  <label class="control-label" for="userid">New Group Member</label>
			  <div class="controls">
				<select id="userid" name="userid" class="input-large">
				<?php
					for($x=0; $x<count($users); $x++)
					{	
						$members = getGroupMembership($groups[$i]);
						if(!in_array($users[$x]['id'],$members))
						{	
							echo "<option value='";
							echo $users[$x]['id'] . "'>";
							echo $users[$x]['name'];
							echo "</option>";
						}
					}
				?>
				</select>
			  </div>
			</div>

			<!-- Button -->
			<div class="control-group">
			  <label class="control-label" for="submit"></label>
			  <div class="controls">
				<button id="submit" name="submit" class="btn btn-success">Add member</button>
			  </div>
			</div>

			</fieldset>
			</form>

			
			

			<form action='editGroup.php' method='POST'
				class="form-horizontal">
			<input type="hidden" name="groupName"
			value="<?echo $groups[$i];?>" />
			<input type="hidden" name="action" 
				value="deleteMember"/>	
			<fieldset>

			<!-- Form Name -->
			<legend>Delete Member</legend>

			<!-- Select Basic -->
			<div class="control-group">
			  <label class="control-label" for="userid">Group Member To Delete</label>
			  <div class="controls">
				<select id="userid" name="userid" class="input-large">
			<?php
				$members = getGroupMembership($groups[$i]);
				for($x=0; $x<count($members); $x++)
				{
					echo "<option value='". $members[$x];
					echo "'>" . $userLookup[$members[$x]];
					echo "</option>";
				}				
			?>
				</select>
			  </div>
			</div>

			<!-- Button -->
			<div class="control-group">
			  <label class="control-label" for="submit"></label>
			  <div class="controls">
				<button id="submit" name="submit" class="btn btn-danger">Delete member</button>
			  </div>
			</div>

			</fieldset>
			</form>

			<hr>
		<?
		}
		include('includes/php/footer.php');
	?>