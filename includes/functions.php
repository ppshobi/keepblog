 <?php
  //testing if query error
function confirm_query($result_set){

 if(!$result_set){
		die("Database query failed.");
	} 
}

//function to find  all subjects
function find_all_subjects(){
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "ORDER BY position ASC";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);
	return $subject_set;
}
function find_all_visible_subjects(){
	global $connection;
	$query = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE visible = 1 ";
	$query .= "ORDER BY position ASC";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);
	return $subject_set;
}
//function to find  all pages for subjects
function find_pages_for_subjects($subject_id){
	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
	$query = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE subject_id = {$safe_subject_id} "; 
	$query .= "ORDER BY position ASC";
	$page_set = mysqli_query($connection, $query);

	confirm_query($page_set);
	return $page_set;
}

//function to find  all pages for subjects
function find_visible_pages_for_subjects($subject_id){
	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
	$query = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE visible = 1 ";
	$query .= "AND subject_id = {$safe_subject_id} "; 
	$query .= "ORDER BY position ASC";
	$page_set = mysqli_query($connection, $query);

	confirm_query($page_set);
	return $page_set;
}

//function to find subject reffered to a subject id

function find_subject_by_id($subject_id){

	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
	$query = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id = {$subject_id} ";
	$query .= "LIMIT 1";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);
	if  ($subject = mysqli_fetch_assoc($subject_set)){
		return $subject;	
	} else{
		return null;
	}
	
}
//function to find pages
function find_all_pages(){
	global $current_page;
	global $current_subject;
	if (isset($_GET["subject"])) {
		$current_subject = find_subject_by_id($_GET["subject"]);
		$current_page=null;
	}elseif (isset($_GET["page"])) {
		$current_page = find_pages_by_id($_GET["page"]);
		$current_subject  =null;
	}else{
		$current_page=null;
		$current_subject= null;
	}
}

function find_selected_page(){
	global $current_page;
	global $current_subject;
	if (isset($_GET["subject"])){
		$current_subject= find_subject_by_id($_GET["subject"]);
		$current_page = find_default_page($current_subject["id"]);
	}
	elseif (isset($_GET["page"])) {
		$current_subject = null;
		$current_page = find_pages_by_id($_GET["page"]);
	}else{
		$current_page = null;
		$current_subject =null;
	}
}
function find_default_page($subject_id){
	$page_set = find_pages_for_subjects($subject_id);
	if ($first_page = mysqli_fetch_assoc($page_set)) {
		return $first_page;
	}else{
		return null;
	}
} 

//fnction to find pages related to an id
function find_pages_by_id($page_id){
	global $connection;

	$safe_page_id = mysqli_real_escape_string($connection, $page_id);
	$query = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE id = {$safe_page_id} ";
	$query .= "LIMIT 1";
	$page_set = mysqli_query($connection, $query);
	confirm_query($page_set);
	if ($page_set = mysqli_fetch_assoc($page_set)) {
		return $page_set;
	}else{
		return null;
	}
}

function redirect_to($new_location){
	header("Location: " . $new_location);
	exit;
}

function find_all_admins()
{
	global $connection;

	$query = "SELECT  * ";
	$query .=  "FROM admins ";
	$query .= "ORDER BY username ASC";
	$admin_set = mysqli_query($connection, $query);
	return $admin_set;
}
function find_admin_by_id($admin_id){
	global $connection;

	$safe_admin_id = mysqli_real_escape_string($connection, $page_id);
	$query = "SELECT * ";
	$query .= "FROM admins ";
	$query .= "WHERE id = {$safe_admin_id} ";
	$query .= "LIMIT 1";
	$page_set = mysqli_query($connection, $query);
	confirm_query($admin_set);
	if ($admin = mysqli_fetch_assoc($admin_set)) {
		return $admin;
	}else{
		return null;
	}
}


//navigation take 2 args
//subject_id if any
//page_id if any
// function navigation($subject_id, $page_id){
// 	$output = "<ul class=\"subjects\">";
// 	$subject_set = find_all_subjects();
// 	while ($subject = mysqli_fetch_assoc($subject_set)) {
// 		$output = "<li";
// 		if($subject["id"] == $subject_id){
// 			$output .=  " class=\"selected\"";
// 		}
// 	$output .= ">";
// 	$output .= "<a href=\"manage_content.php?subject=";
// 	$output .= urlencode($subject["id"]);
// 	$output .= "\">";
// 	$output .=  $subject["menu_name"];
// 	$output .= "</a>";
	  
// 	$page_set=find_pages_for_subjects($subject["id"]);
// 	$output .= "<ul class=\"pages\">";
// 	while ($pages = mysqli_fetch_assoc($page_set)) {							 
// 		$output .= "<li";
// 		if ($pages["id"] == $page_id){
// 		    $output .= " class=\"selected\"";
// 		}
// 	    $output .= ">";
// 	    $output .= "<a href=\"manage_content.php?page=";
// 	    $output .= urlencode($pages["id"]);
// 	    $output .= "\">";
// 	    $output .= $pages["menu_name"];
// 		$output .= "</a></li>";
// 	}

// 	mysqli_free_result($page_set);
// 	$output .= "</ul></li>";
//    }
// 	mysqli_free_result($subject_set);
// 	$output .= "</ul>";
// }
?>