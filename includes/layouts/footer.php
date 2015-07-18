<footer>
<p>Copyright <?php echo date("Y"); ?></p>
</footer>
<?php
//closing connection if open
if (isset($connection)) {
	mysqli_close($connection);
}
  
?>