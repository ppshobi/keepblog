<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context = "admin"; ?> 
<?php find_selected_page(); ?>
<?php
 if(!$current_subject){
 	//subject id was missing or invalid or coudn'nt find on db
    redirect_to("manage_content.php");
 }

?>

<?php
	$subject_set = find_all_subjects();
?>
<?php 
	find_all_pages();
?>
<?php //form processing ?>

<?php
if (isset($_POST['submit'])) {

 
 
 //validations
 $required_fields = array("menu_name", "position", "visible");
 validate_presences($required_fields);

 $fields_with_max_lengths = array("menu_name" => 30);
 validate_max_lengths($fields_with_max_lengths);

 //escape all strings
 $menu_name = mysqli_real_escape_string($connection, $menu_name);

 if (empty($errors)) {
		 	// perform update
		//process the form
 	     $id =$current_subject["id"];
		 $menu_name = $_POST["menu_name"]; 
		 $position = (int) $_POST["position"];
		 $visible = (int) $_POST["visible"];

		 //Perform database query
		 $query = "UPDATE subjects SET ";
		 $query .= "menu_name  = '{$menu_name}', ";
		 $query .= "position = {$position}, ";
		 $query .= "visible = {$visible} ";
		 $query .= "WHERE id = {$id} ";
		 $query .= "LIMIT 1";// update only one record
		 $result = mysqli_query($connection, $query);

		 if ($result && mysqli_affected_rows($connection) >= 0) {
		 	//sucess
		 	$_SESSION["message"] = "Subject EDITED!";
		 	redirect_to("manage_content.php");
		 }else{
		 	//failure
		 	$message = "Subject Editing Failed";
		 }
			  
		}
}
else{
	// probably get req
}
?>



<?php include("../includes/layouts/header.php");?>

	<div id="main">
		<div id="navigation">
			<?php include("../includes/layouts/navigation.php");?>

		</div>
		<div id="page">
			<?php if (!empty($message)) {
				echo "<div  class=\"message\">" . htmlentities($message) . "</div>";
			}?>

			<h2>Edit Subject : <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
			<form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
				<p>
					Subject Name:<input name="menu_name" type="text" value="<?php echo $current_subject["menu_name"]; ?>"/> <br/>
				</p>
				<p>
					Position: <select name="position">
								<?php
									$subject_set = find_all_subjects();
									$subject_count  = mysqli_num_rows($subject_set);
 									for ($count=1; $count<=($subject_count)  ; $count++) { 
 										echo "<option value=\"$count\"";
 										if ($current_subject["position"] == $count) {
 											echo " selected ";

 										} 										 										echo ">$count </option>";
 									}
								 ?>
								
							</select> 
				</p>
				<p>
					<input type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) {echo "checked";} ?> />Visible
					<input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) {echo "checked";} ?> />Invisible
				</p>
				
				<input type="submit" name="submit" value="submit" />
				<a href="manage_content.php"><input type="button" value="Cancel"></a>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]) ?>" onclick="return confirm('Are You  Sure to Delete?');">Delete Subject</a>
			</form>
			

		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

