<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<h1>Login page</h1>
		<?php if(isset($parameters['error'])){ ?>
			<h2><?=$parameters['error'];?></h2>
		<?php } ?>
		<form action="/login" method="POST">
		    <label for="user">Username :</label>
		    <input type="text" name="user">

		    <label for="password">Password :</label>
		    <input type="password" name="password">
		    
		    <input type="submit" value="Login">
		</form>
	</body>
</html>