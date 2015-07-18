<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context = "admin"; ?> 
<?php
	$admin_set = find_all_admins();
?>

<?php include("../includes/layouts/header.php");?>

	<div id="main">
		<div id="navigation">
			<a href="admin.php">&laquo; Main Menu</a>
		</div>
		<div id="page">
			<?php echo message(); ?>
				
					<h2>Manage Admins</h2>
					<table>
						<tr>
							<th>User Name</th>
							<th>Actions</th>
						</tr>
						<?php while($admin = mysqli_fetch_assoc($admin_set)){ ?>
						<tr>
							<td><?php echo htmlentities($admin["username"]);?></td>
							<td><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]);?>">Edit</a></td>
							<td><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]);?>" onclick = "return confirm ("Are You Sure?");">Delete</a></td>

						</tr>
						<?php } ?>

					</table>
					<br/>
					<a href="new_admin.php">Add New admin</a>


				<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>"> Edit Subject </a>                    
			

		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

