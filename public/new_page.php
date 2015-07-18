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

 if (empty($errors)) {
		 	// perform update
		//process the form
 	     $subject_id =$current_subject["id"];
		 $menu_name = $_POST["menu_name"]; 
		 $position = (int) $_POST["position"];
		 $visible = (int) $_POST["visible"];
		 $content_non_safe=$_POST["content"];
         //escaping content input
         $content = mysqli_real_escape_string($connection,$content_non_safe);
		 //Perform database query
		 $query = "INSERT INTO pages (";
		 $query .= " subject_id, menu_name, position, visible, content";
		 $query .= ") VALUES (";
		 $query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
		 $query .= ")";
		echo $query;
		 $result = mysqli_query($connection, $query);

		 if ($result) {
		 	//sucess
		 	$_SESSION["message"] = "Page Created!";
		 	redirect_to("manage_content.php?subject=" .
		 		urlencode($current_subject["id"]));
		 }else{
		 	//failure
		 	$message = "Page Creation Failed";
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

			<h2>Create Page : </h2>
			<form action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
				<p>
					Menu Name:<input name="menu_name" type="text" value=""/> <br/>
				</p>
				<p>
					Position: <select name="position">
								<?php
									$page_set = find_pages_for_subjects($current_subject["id"]);
									$page_count  = mysqli_num_rows($page_set);
 									for ($count=1; $count<=($page_count+1)  ; $count++) { 
 										echo "<option value=\"$count\">$count </option>";
 									}
								 ?>
								
							</select> 
				</p>
				<p>
					<input type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) {echo "checked";} ?> />Visible
					<input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) {echo "checked";} ?> />Invisible
				</p>
				<p>Content:<br/>
					<textarea name="content" rows="20" cols="80"></textarea>

				</p>
				
				<input type="submit" name="submit" value="Create Page" />
				<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
			</form>
			

		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

