<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php $layout_context = "admin"; ?> 
<?php
	$subject_set = find_all_subjects();
?>

<?php include("../includes/layouts/header.php");?>
<?php 
	find_all_pages();
?>

	<div id="main">
		<div id="navigation">
			<?php include("../includes/layouts/navigation.php");?>

		</div>
		<div id="page">
			<?php echo message();?>
			<?php $errors = errors();?>
			<?php echo errors($errors); ?>


			<h2>Create New Subject</h2>
			<form action="create_subject.php" method="post">
				<p>
					Subject Name:<input name="menu_name" type="text" value=""/> <br/>
				</p>
				<p>
					Position: <select name="position">
								<?php
									$subject_set = find_all_subjects();
									$subject_count  = mysqli_num_rows($subject_set);
 									for ($count=1; $count<=($subject_count+1)  ; $count++) { 
 										echo "<option value=\"$count\">$count </option>";
 									}
								 ?>
								
							</select> 
				</p>
				<p>
					<input type="radio" name="visible" value="1" />Visible
					<input type="radio" name="visible" value="0" />Invisible
				</p>
				
				<input type="submit" name="submit" value="submit" />
				<a href="manage_content.php"><input type="button" value="Cancel"></a>
			</form>
			

		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

