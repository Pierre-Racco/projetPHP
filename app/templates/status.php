<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<?php
			echo "<p>".$status->getMessage()."</p>";
			echo "<p>".$status->getUserId()."</p>";
			echo "<p>".$status->getDate()."</p>";
			
		if(isset($_SESSION['user'])){
			$userId = $_SESSION['user']->getId();
		} else {
			$userId = null;
		}
		if ($userId === $status->getUserId()) {
          ?>
		<form action="/statuses/<?= $status->getId(); ?>" method="POST">
		    <input type="hidden" name="_method" value="DELETE">
		    <input type="submit" value="Delete">
		</form>
		<?php } ?>
	</body>
</html>