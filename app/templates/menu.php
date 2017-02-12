<div class="menu panel panel-default">
	<nav class="panel-body">
		<div class="align-left">
			<?php if(isset($_SESSION['user'])){ ?>
				<h1> Bienvenue <?=$_SESSION['user']->getUsername();?> </h1>
			<?php } else { ?>
				<h1> Connectez-vous ! </h1>
			<?php }  ?>
		</div>
		<ul>	
			<?php if(isset($_SESSION['user'])){ ?>
				<li><a href="/logout">Logout</a></li>
			<?php } else { ?>
				<li><a href="/login">Login</a></li>
				<li><a href="/signin">Signin</a></li>
			<?php }  ?>
		</ul>
	</nav>
</div>