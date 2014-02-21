		<div class="row">
			<div class="span12">
				<div class="navbar">
					<div class="navbar-inner">
						
						<ul class="nav">
							<li><a href="index.php">Home</a></li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									Repos <b class="caret"></b>
								</a>
								
								<ul class="dropdown-menu">
									<li><a href="listRepos.php">Repo List</a></li>
									<li><a href="makeRepo.php">Add/Delete a Repo</a></li>
									<?php
									if($_SESSION['isAdmin'] == 1)
									{ ?>
									<li><a href="editPerms.php">Edit Repo Permissions</a></li>
									<?php } ?>
								</ul>
								
							</li>
						<?php
							if($_SESSION['isAdmin'] == 1)
							{ ?>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									Users And Groups <b class="caret"></b>
								</a>
								
								<ul class="dropdown-menu">
									<li><a href="addUser.php">Add/Delete User</a></li>
									<li><a href="addGroup.php">Add/Delete Group</a></li>
									<li><a href="editGroup.php">Edit Group Membership</a></li>
								</ul>
								
							</li>
							<?php } ?>
							<li><a href="changePassword.php">Change Password</a></li>							
							<li><a href="logout.php">Logout</a></li>
							
						</ul>
						<div style="float: right;">
						Free Disk:	
						<?php echo percentageFreeDiskSpace(SVNFILEPATH). "%"; ?>
						</div>	
					</div>
				</div>
				
			</div>
		</div>
