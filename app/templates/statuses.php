<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php foreach($parameters as $status){ ?>
			<div>
				<p><?=$status->getName();?></p>
				<p><?=$status->getMessage();?></p>
				<p><?=$status->getDate();?></p>
				<a href='/statuses/".$status->getId()."'></a>
			</div>
		<?php } ?>
		<form action="/statuses" method="POST" class="input-group">
		    <label for="message">Message:</label>
		    <textarea class="form-control" name="message"></textarea>
		    
		    <input type="hidden" name="_method" value="POST">
		    <input type="submit" value="Tweet!">
		</form>
	</body>
</html>