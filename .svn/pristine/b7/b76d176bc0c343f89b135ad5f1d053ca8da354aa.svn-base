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

?>

	<?	
		if(!isset($_POST['repoToEdit']) && !isset($_POST['action']))
		{
			$repos = listRepos();
	?>
		<form name="repoToEdit" action="editPerms.php" method="POST" 
			class="form-horizontal">
		<input type="hidden" name="action" value="select" />
		<fieldset>

		<!-- Form Name -->
		<legend>Choose Repo To Edit</legend>

		<!-- Select Basic -->
		<div class="control-group">
		  <label class="control-label" for="repoToEdit">Choose Repo</label>
		  <div class="controls">
			<select id="repoToEdit" name="repoToEdit" class="input-large">
			<?php
				for($i=0; $i<count($repos); $i++)
				{
					echo "<option value='" . $repos[$i];
					echo "'>" . $repos[$i] . "</option>";
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
				class="btn btn-info">Edit Permissions</button>
		  </div>
		</div>

		</fieldset>
		</form>

<?php 
	}
	else
	{
	if($_POST['action'] == 'select')
	{
		$perms = getRepoPerms($_POST['repoToEdit']);
		$groups = listGroups();
		$groupLookupTable = getGroupNameToIdTable();


		?>
	<form class="form-horizontal" action="editPerms.php" method="POST">
	<input type="hidden" name="repoToEdit" 
		value="<?php echo $_POST['repoToEdit']; ?>" />
	<input type="hidden" name="action" value="save" />
	<fieldset>

	<!-- Form Name -->
	<legend>Edit <?php echo $_POST['repoToEdit']; ?> Permissions</legend>

	<!-- Select Basic -->
	<?php
	  
	for($i=0; $i<count($groups); $i++)
	{
		$groupId = $groupLookupTable[$groups[$i]];	
		$groupPerms = $perms[$groupId];
	?>
		<div class="control-group">
		<label class="control-label" 
		for="groupName<?php echo $i; ?>">
		<?php echo $groups[$i]; ?> Permissions:</label>
		  <div class="controls">
		    <select id="<?php echo $groups[$i]; ?>"
			 name="<?php echo $groups[$i]; ?>" class="input-small">
		      
		<?php
			switch($groupPerms)
			{
				case "0":
				echo "<option value='0' selected>None</option>";
		      		echo "<option value='r'>Read</option>";
		      		echo "<option value='w'>Write</option>";
				break;

				case "r":
				echo "<option value='0' >None</option>";
		      		echo "<option value='r' selected>Read</option>";
		      		echo "<option value='w'>Write</option>";
				break;
				
				case "w":
				echo "<option value='0' >None</option>";
		      		echo "<option value='r' >Read</option>";
		      		echo "<option value='w' selected>Write</option>";
				break;
					
			}
		?>
		    </select>
		  </div>
		</div>
	<?
	}
	?>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="submit"></label>
	  <div class="controls">
	    <button id="submit" name="submit" 
		class="btn btn-success">Update Permissions</button>
	  </div>
	</div>

	</fieldset>
	</form>
	
		<?
	}//end select if
	if($_POST['action'] == 'save')
	{
		$repo = $_POST['repoToEdit'];	
		$groups = listGroups();
		$groupLookupTable = getGroupNameToIdTable();
		for($i=0; $i<count($groups); $i++)
		{
			setRepoPerms($repo,
				$groupLookupTable[$groups[$i]],
				$_POST[$groups[$i]]);
		}
		echo "<h3>Updated Permissions for $repo</h3>";
	
	}		
	} //end else
include('includes/php/footer.php'); ?>
