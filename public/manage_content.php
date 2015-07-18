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
			<a href="admin.php">&laquo; Main Menu</a><br/>
			<?php include("../includes/layouts/navigation.php");?>
             <p>
				<b><a href="new_subject.php">+ Create New Subject</a></b>
			</p>
		</div>
		<div id="page">
			<?php echo message(); ?>
			<?php if ($current_subject) { ?>
				
					<h2>Manage Subject</h2>

					Menu Name: <?php echo htmlentities($current_subject["menu_name"]); ?> <br/>
					Position : <?php echo $current_subject["position"] ; ?><br/>
			 		Visible : <?php echo $current_subject["visible"] ==1 ? 'Yes' : 'No' ; ?><br/>
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>"> Edit Subject </a>
			<div style="margin-top: 2em; border-top:1px solid #000">
				 <h3>Pages in This Subject:</h3>
				 <ul>
				 	<?php
				 	    $subject_pages= find_pages_for_subjects($current_subject["id"]);
				 	    while ($page = mysqli_fetch_assoc($subject_pages)) {
				 	    	echo "<li>";
				 	    	$safe_page_id = urlencode($page["id"]);
				 	    	echo "<a href=\"manage_content.php?page={$safe_page_id}\">";				 
				 	    	echo htmlentities($page["menu_name"]);
				 	    	echo "</a>";
				 	    	echo "</li>";
				 	    }
				 	?>
				 </ul>
				 <br/>
				 <a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]);?>">Add Page for This Subject>></a>

			</div>                    
			<?php } elseif($current_page){ ?>
					
					<h2>Manage Page</h2>

					Name of page :<?php echo htmlentities($current_page["menu_name"]) ; ?><br/>
					Position : <?php echo $current_page["position"] ; ?><br/>
			 		Visible : <?php echo $current_page["visible"] ==1 ? 'Yes' : 'No' ; ?><br/>
			 		Content : <br/>
			 		<div class="view-content">
			 			<?php echo htmlentities($current_page["content"]) ; ?>
			 		</div>
			 		<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>"> Edit page </a>
					

			<?php } else { ?>

					<?php echo "Nothing to Show. please select a page or subject"; ?>

			<?php } ?>


		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

