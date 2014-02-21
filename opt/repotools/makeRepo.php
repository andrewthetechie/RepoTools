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

	
	if(isset($_POST['repoName']) && isset($_POST['action']))
	{
		switch($_POST['action'])
		{
			case 'add':
				$repoName= clean($_POST['repoName']);
				if(!repoExists($repoName))
				{
					addRepo($repoName);
					echo "<h3>Added repo $repoName </h3>";
				}
				else
				{
					echo "<h3>$repoName already exists.";
					echo "</h3><p>Repo names must be";
					echo " unique</p>";
				}
				break;

			case 'delete':
				deleteRepo($_POST['repoName']);
				echo "<h3>Deleted Repo ";
				echo $_POST['repoName'] . "</h3>";
				break;

			case 'undelete':
				restoreRepo($_POST['repoName']);
				echo "<h3>Starting restore process for ";
				echo $_POST['repoName'] ."</h3>";
				echo "<p>Restore can take up to an hour</p>";
				break;

			default:
				echo "<h3>Some sort of error has occured</h3>";
				break;

		}	

	}

?>


	<form name="createRepo" action="makeRepo.php" method="POST" 
		class="form-horizontal">
	<fieldset>
	<input type="hidden" name="action" value="add" />

	<!-- Form Name -->
	<legend>Add A Repo</legend>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="repoName">Name Of Repo</label>
	  <div class="controls">
		<input id="repoName" name="repoName" type="text" placeholder="NewRepoName" class="input-xlarge" required="">
		<p class="help-block">No spaces or special chars</p>
	  </div>
	</div>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="submit"></label>
	  <div class="controls">
		<button id="submit" name="submit" class="btn btn-success">Create Repo</button>
	  </div>
	</div>

	</fieldset>
	</form>


	<form name="deleteRepo" action="makeRepo.php" method="POST" 
		class="form-horizontal">
	<fieldset>
	<input type="hidden" name="action" value="delete" />

	<!-- Form Name -->
	<legend>Delete A Repo</legend>

	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="repoName">Repo</label>
	  <div class="controls">
	    <select id="repoName" name="repoName" class="input-large">
		<?php
			$repos = listRepos();
			for($i=0; $i<count($repos); $i++)
			{
				$current = $repos[$i];
				echo "<option value='$current'>$current";
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
	    <button id="submit" name="submit" class="btn btn-danger">Delete</button>
	  </div>
	</div>

	</fieldset>
	</form>


	<form name="deleteRepo" action="makeRepo.php" method="POST" 
		class="form-horizontal">
	<fieldset>
	<input type="hidden" name="action" value="undelete" />

	<!-- Form Name -->
	<legend>Restore A Repo</legend>

	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="repoName">Repo</label>
	  <div class="controls">
	    <select id="repoName" name="repoName" class="input-large">
		<?php
			$repos = listDeletedRepos();
			for($i=0; $i<count($repos); $i++)
			{
				$current = $repos[$i];
				echo "<option value='$current'>$current";
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
	    <button id="submit" name="submit" class="btn btn-warning">Undelete</button>
	  </div>
	</div>

	</fieldset>
	</form>
<?php

	
	
	include('includes/php/footer.php');

?>
