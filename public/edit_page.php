<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context = "admin"; ?> 
<?php find_selected_page(); ?>
<?php
 if(!$current_page){
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
 if (empty($errors)) {
		 	// perform update
		//process the form
 	     $id =$current_page["id"];
		 $menu_name = $_POST["menu_name"]; 
		 $position = (int) $_POST["position"];
		 $visible = (int) $_POST["visible"];
		 $content_non_safe=$_POST["content"];
         //escaping content input
         $content = mysqli_real_escape_string($connection,$content_non_safe);
		  //Perform database query
		 $query = "UPDATE pages SET ";
		 $query .= "menu_name  = '{$menu_name}', ";
		 $query .= "position = {$position}, ";
		 $query .= "visible = {$visible}, ";
		 $query .= "content = '{$content}' ";
		 $query .= "WHERE id = {$id} ";
		 $query .= "LIMIT 1";// update only one record
		 echo $query;
		 $result = mysqli_query($connection, $query);
		 if ($result && mysqli_affected_rows($connection)>=0) {
		 	//sucess
		 	$_SESSION["message"] = "Page EDITED!";
		 	redirect_to("manage_content.php?page={$id}");
		 }
		 else{
		 	//failure
		 	$_SESSION["message"] = "Page Editing Failed";
		 	$message = "page Editing Failed";
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

			<h2>Edit Page : <?php echo htmlentities($current_page["menu_name"]); ?></h2>
			<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">
				<p>
					Menu Name:<input name="menu_name" type="text" value="<?php echo $current_page["menu_name"]; ?>"/> <br/>
				</p>
				<p>
					Position: <select name="position">
								<?php

									$page_set = find_pages_for_subjects($current_page["subject_id"]);
									$page_count  = mysqli_num_rows($page_set);
 									for ($count=1; $count<=($page_count); $count++) { 
 										echo "<option value=\"$count\"";
 										if ($current_page["position"] == $count) {
 											echo "class=\"selected\"";
 										} 					
 										echo ">{$count}</option>";					 										echo ">$count </option>";
 									}
								 ?>
								
							</select> 
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) {echo "checked";} ?> />Visible
					<input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) {echo "checked";} ?> />Invisible
				</p>
				<p>Content:<br/>
					<textarea name="content" rows="20" cols="80"><?php echo htmlentities($current_page["content"]); ?></textarea>

				</p>
				
				<input type="submit" name="submit" value="Update Page" />
				<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
			</form>
			<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]) ?>" onclick="return confirm('Are You  Sure to Delete Page?');">Delete Page</a>

		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

