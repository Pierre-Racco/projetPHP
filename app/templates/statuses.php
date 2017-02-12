<!DOCTYPE html>
<html>
	<head>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'menu.php'; ?>
		<div class="flex-horizontal">
			<div class="left-column flex-vertical">
			</div>
			<div class="middle-column flex-vertical">
				
				<div class="panel panel-primary flex-vertical write-meow">
					<div class="panel-heading">
						<h1>Exprimez-vous :</h1>
					</div>
					<div class="panel-body">
						<form action="/statuses" method="POST" class="input-group">
						    <textarea <?php if(!isset($_SESSION['user'])){ ?> disabled <?php } ?> class="form-control textarea-style" name="message" placeholder="Votre meow ici"></textarea>
						    
						    <input type="hidden" name="_method" value="POST">
						    <input <?php if(!isset($_SESSION['user'])){ ?> disabled <?php } ?> class="btn btn-primary send-meow" type="submit" value="Meow!">
						</form>
					</div>
					
				</div>
				
				<div class="flex-vertical">
					<?php foreach($parameters as $status){
						if(isset($_SESSION['user'])){
							$userId = $_SESSION['user']->getId();
						} else {
							$userId = null;
						}
						
						
					?>
						<div class="status-element">
							<p><?=$status->getMessage();?></p>
							<p><?=$status->getDate();?></p>
							<a href='/statuses/<?=$status->getId();?>'>Lien</a>
							<?php if ($userId === $status->getUserId()) {
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