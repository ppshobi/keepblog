<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>

<?php $layout_context = "admin"; ?> 
<?php
 $current_subject = find_subject_by_id($_GET["subject"]);
 if(!$current_subject){
 	//subject id was missing or invalid or coudn'nt find on db
    redirect_to("manage_content.php");
 }
// finding if any pages left in subject
 $pages_set = find_pages_for_subjects($current_subject["id"]);
 if (mysqli_num_rows($pages_set)>0) {

 	 $_SESSION["message"] = "Can't Do because pages left in subject";
	 redirect_to("manage_content.php?subject={$current_subject["id"]}");
 }

  $id = $current_subject["id"];
  $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";

  $result = mysqli_query($connection, $query);

		 if ($result && mysqli_affected_rows($connection) == 1) {
		 	//sucess
		 	$_SESSION["message"] = "Subject DELETED!";
		 	redirect_to("manage_content.php");
		 }else{
		 	//failure
		 $_SESSION["message"] = "Subject DELETION Failed";
		 redirect_to("manage_content.php?subject={$id}");
		 }
?>