<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
		<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<div class="flex-horizontal">
			<div class="left-column flex-vertical">
				<blockquote class="twitter-tweet" data-lang="fr"><p lang="en" dir="ltr">PHP = PreHistoric Programming</p>&mdash; Hipster Hacker (@hipsterhacker) <a href="https://twitter.com/hipsterhacker/status/398863567400615936">8 novembre 2013</a></blockquote>
			</div>
			<div class="middle-column flex-vertical">
				<h1>Tous les meows : </h1>
				<div class="panel panel-primary flex-vertical write-meow">
					<div class="panel-heading">
						<h1>Exprimez-vous :</h1>
					</div>
					<div class="panel-body">
						<form action="/statuses" method="POST" class="input-group">
						    <textarea class="form-control textarea-style" name="message" placeholder="Votre meow ici"></textarea>
						    
						    <input type="hidden" name="_method" value="POST">
						    <input class="btn btn-primary send-meow" type="submit" value="Meow!">
						</form>
					</div>
					
				</div>
				
				<div class="flex-vertical">
					<?php foreach($parameters as $status){
						if(isset($_SESSION['user'])){
							$userUsername = $_SESSION['user']->getUsername();
						} else {
							$userUsername = null;
						}					
						
					?>
						<div class="status-element">
							<h3><?=$status->getUserUsername();?></h3>
							<p><?=$status->getMessage();?></p>
							<p><?=$status->getDate();?></p>
							<a href='/statuses/<?=$status->getId();?>'>Lien</a>
							<?php if ($userUsername === $status->getUserUsername()) {
            				?>
							<form action="/statuses/<?= $status->getId(); ?>" method="POST">
							  	<div class="group-btn">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
									<input type="submit" class="form-control" aria-label="..." value="">
								</div>
								<input type="hidden" name="_method" value="DELETE">
							</form>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="right-column flex-vertical">
			</div>
		</div>

	</body>
</html>