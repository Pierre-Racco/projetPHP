<?php
	echo "<p>".$parameters['message']."</p>";
	echo "<p>".$parameters['name']."</p>";
	echo "<p>".$parameters['date']."</p>";
?>
<form action="/statuses/<?= $id ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Delete">
</form>