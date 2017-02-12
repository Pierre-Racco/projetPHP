<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'menu.php'; 

			echo "<p>".$status->getUserUsername()."</p>";
			echo "<p>".$status->getMessage()."</p>";
			echo "<p>".$status->getDate()."</p>";
			
		if(isset($_SESSION['user'])){
			$userUsername = $_SESSION['user']->getUsername();
		} else {
			$userUsername = null;
		}
		if ($userUsername === $status->getUserUsername()) {
          ?>
		<form action="/statuses/<?= $status->getId(); ?>" method="POST">
		    <input type="hidden" name="_method" value="DELETE">
		    <input type="submit" value="Delete">
		</form>
		<?php } ?>
	</body>
</html>