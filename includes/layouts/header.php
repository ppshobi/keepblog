<?php if (!isset($layout_context)) {
	$layout_context = "public";
} ?>
<html>
<head>
	<title>||KeepBlog||</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<header>
		<h1>KeepBlog <?php if ($layout_context == "admin") {echo "Admin";} ?></h1>
	</header>