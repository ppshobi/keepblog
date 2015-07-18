<?php require_once("../includes/sessions.php");?>
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>
<?php $layout_context = "admin"; ?> 

<?php
if (isset($_POST['submit'])) {

 //process the form
 $menu_name = $_POST["menu_name"]; 
 $position = (int) $_POST["position"];
 $visible = (int) $_POST["visible"];
 
 //validations
 $required_fields = array("menu_name", "position", "visible");
 validate_presences($required_fields);

 $fields_with_max_lengths = array("menu_name" => 30);
 validate_max_lengths($fields_with_max_lengths);


 //escape all strings
 $menu_name = mysqli_real_escape_string($connection, $menu_name);

 if (!empty($errors)) {
 	$_SESSION["errors"] = $errors;
 	redirect_to("new_subject.php");
 }

 //Perform database query
 $query = "INSERT INTO subjects (";
 $query .= " menu_name, position, visible";
 $query .= ") VALUES (";
 $query .= " '{$menu_name}', {$position}, {$visible}";
 $query .= ")";
 $result = mysqli_query($connection, $query);

 if ($result) {
 	//sucess
 	$_SESSION["message"] = "Subject Created!";
 	redirect_to("manage_content.php");
 }else{
 	//failure
 	$_SESSION["message"] = "Subject Creation Failed";
 	redirect_to("new_subject.php");
 }
	  
}else{
	//probably get request
    redirect_to("new_subject.php");
}
?>

<?php
//closing connection if open
if (isset($connection)) {mysqli_close($connection);}  
?>
