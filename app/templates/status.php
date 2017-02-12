<?php
	echo "<p>".$status->getMessage()."</p>";
	echo "<p>".$status->getUserId()."</p>";
	echo "<p>".$status->getDate()."</p>";
?>
<form action="/statuses/<?= $status->getId(); ?>" method="POST">
    <input type="hidden" name="_method" value="DELETE">
    <input type="submit" value="Delete">
</form>