<?php

foreach($parameters as $status){
	echo "<p> Status : </p>";
	echo "<p>".$status['message']."</p>";
	echo "<p>".$status['name']."</p>";
	echo "<p>".$status['date']."</p>";
    echo "<a href='/statuses/".$status['id']."'>Lien</a>";
	echo "<p> -------------- </p>";
}

?>
<form action="/statuses" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username">

    <label for="message">Message:</label>
    <textarea name="message"></textarea>
    
    <input type="hidden" name="_method" value="POST">
    <input type="submit" value="Tweet!">
</form>