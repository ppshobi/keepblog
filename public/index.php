<?php require_once("../includes/sessions.php");?>
<?php $layout_context = "public"; ?> 
<?php require_once("../includes/db-connection.php");?>
<?php require_once("../includes/functions.php");?>

<?php
	$subject_set = find_all_visible_subjects();
?>

<?php include("../includes/layouts/header.php");?>
<?php 
	find_all_pages();
?>

	<div id="main">
		<div id="navigation">
			<?php include("../includes/layouts/public_navigation.php");?>

		</div>
		<div id="page">
			<?php if($current_page){ ?>
			 			<h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
			 			<?php echo nl2br(htmlentities($current_page["content"])) ; ?>
			<?php } else { ?>

					<?php echo "Welcome "; ?>

			<?php } ?>


		</div><!-- ENd of page -->
	</div> <!-- endof main -->
	
<?php include("../includes/layouts/footer.php"); ?>
</body>
</html>

