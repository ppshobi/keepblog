<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>

<?php $layout_context = "admin"; ?> 
<?php
 $current_page = find_pages_by_id($_GET["page"]);
 if(!$current_page){
 	//subject id was missing or invalid or coudn'nt find on db
    redirect_to("manage_content.php");
 }
  $id = $current_page["id"];
  $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);
		 if ($result && mysqli_affected_rows($connection) == 1) {
		 	//sucess
		 	$_SESSION["message"] = "Page DELETED!";
		 	redirect_to("manage_content.php");
		 }else{
		 	//failure
		 $_SESSION["message"] = "Page DELETION Failed";
		 redirect_to("manage_content.php?page={$id}");
		 }
?>