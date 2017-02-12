<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<?php foreach($parameters as $status){ ?>
			<div>
				<p><?=$status->getUserId();?></p>
				<p><?=$status->getMessage();?></p>
				<p><?=$status->getDate();?></p>
				<a href='/statuses/<?=$status->getId();?>'>Lien</a>
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