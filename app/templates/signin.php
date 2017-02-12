<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<h1>Sign in page</h1>
		<?php if(isset($parameters['error'])){ ?>
			<h2><?=$parameters['error'];?></h2>
		<?php } ?>
		<form action="/signin" method="POST">
		    <label for="user">Username :</label>
		    <input type="text" name="username">

		    <label for="password">Password :</label>
		    <input type="password" name="password">
		    
		    <input type="submit" value="Sign In">
		</form>
	</body>
</html>