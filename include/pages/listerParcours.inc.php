<?php
$pdo=new Mypdo();
	$parcoursManager = new ParcoursManager($pdo);
	$parcours=$parcoursManager->getAllParcours();
	$nbParcours=$parcoursManager->getNbParcours();
				?>
<h1>Lister des Parcours proposes </h1>

<p>Actuellement <?php echo $nbParcours; ?> villes a ete ajoutee</p>


	<table>
		<tr><th>Numéro</th><th>Nom ville</th><th>Nom ville</th><th>Nombre de Km</th></tr>
		<?php
		foreach ($parcours as $parcour){ ?>
			<tr>
				<td><?php echo $parcour->getParNum();?></td>
				<td><?php echo $parcour->getVilNum1();?></td>
				<td><?php echo $parcour->getVilNum2();?></td>
				<td><?php echo $parcour->getParKm();?></td>
			</tr>
		<?php } ?>
		</table>
