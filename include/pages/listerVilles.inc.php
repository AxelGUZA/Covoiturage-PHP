<?php 
	$pdo=new Mypdo();
	$villeManager = new VilleManager($pdo);
	$villes=$villeManager->getAllVille();
	$nbVille=$villeManager->getNBVille();
				?>
<h1>Lister des villes</h1>

<p>Actuellement <?php echo $nbVille; ?> villes a ete ajoutee</p>


	<table>
		<tr><th>Numéro</th><th>Nom</th></tr>
		<?php
		foreach ($villes as $ville){ ?>
			<tr><td><?php echo $ville->getVilNum();?>
			</td><td><?php echo $ville->getVilNom();?>

			</td></tr>
		<?php } ?>
		</table>

