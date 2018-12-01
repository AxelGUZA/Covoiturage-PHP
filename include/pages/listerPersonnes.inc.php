<?php
	$pdo=new Mypdo();
	$personnesManager = new PersonneManager($pdo);
	$personnes=$personnesManager->getAllPersonne();
	$nbPersonne=$personnesManager->getNbPersonne();


if(empty($_POST["per_num"])){

				?>
<h1>Lister des Personne enregistrees </h1>

<p>Actuellement <?php echo $nbPersonne; ?> personnes enregistrees</p>


	<table>
		<tr><th>Numéro</th><th>Nom</th><th>Prenom</th></tr>
		<?php
		foreach ($personnes as $personne){ ?>
			<tr>
				<td><form action="index.php?page=2" method="POST"><input type="submit" name="per_num" value="<?php echo $personne->getPerNum();?>"/></form></td>
				<td><?php echo $personne->getPerNom();?></td>
				<td><?php echo $personne->getPerPrenom();?></td>
			</tr>
		<?php } ?>
		</table>
<?php 

}else if (!empty($_POST["per_num"])){ 



	$etudiantManager = new EtudiantManager($pdo);
	$etudiant = $etudiantManager->getAllEtudiant();
	$testEtudiant =$etudiantManager->getBonEtudiant($_POST["per_num"]);
		//var_dump ($testEtudiant);
	//var_dump($etudiantManager->getBonEtudiantBool($_POST["per_num"]));
	$check = $etudiantManager->getBonEtudiantBool($_POST["per_num"]);

	
		if ( $check == "true") { 
			$personneById=$personnesManager->getPersonneById($testEtudiant->getPerNum());
			$departementManager =  new DepartementManager($pdo);
			$donnesDepartement = $departementManager->getDepartementById($testEtudiant->getDepNum());
			//var_dump ($donnesDepartement);
			$villeManager = new VilleManager($pdo);
			$ville = $villeManager->getBonneVille($donnesDepartement->getVilNum());
			foreach ($donnesDepartement as $donneDepartement){ 
				echo $donneDepartement->getDepNom();
				echo $donneDepartement->getVilNum();
			}

			//$vilNumDepartement = $donnesDepartement->getVilNum();
			/*$villeManager =  new VilleManager($pdo);
			$ville = $villeManager->getBonneVille();*/
			 ?>
			<h1>Detail sur l'etudiant <?php echo $personneById->getPerNom();?></h1>
			<table>
				<tr><th>Prenom</th><th>Mail</th><th>Tel</th><th>Departement</th><th>Ville</th></tr>	
					<tr>
						<td><?php echo $personneById->getPerPrenom();?></td>
						<td><?php echo $personneById->getPerMail();?></td>
						<td><?php echo $personneById->getPerTel();?></td>
						<td><?php echo $donnesDepartement->getDepNom();?></td>
						<td><?php echo $ville->getVilNom();?></td>
					</tr>
				
			</table>

<?php } else { 
	$personneById=$personnesManager->getPersonneById($_POST["per_num"]);
	$salarieManager = new SalarieManager($pdo);
	$salarie = $salarieManager->getAllSalarie();
	$recupSalari = $salarieManager->getBonSalarie($_POST["per_num"]);

	$fonctionManager = new FonctionManager($pdo);
	$fonction = $fonctionManager->getFonctionById($recupSalari->getFonNum());
?>
	<h1>Detail du salarier <?php echo $personneById->getPerNom();?></h1>
			<table>
				<tr><th>Prenom</th><th>Mail</th><th>Tel</th><th>Tel Pro</th><th>Fonction</th></tr>	
					<tr>
						<td><?php echo $personneById->getPerPrenom();?></td>
						<td><?php echo $personneById->getPerMail();?></td>
						<td><?php echo $personneById->getPerTel();?></td>
						<td><?php echo $recupSalari->getSalTelprof();?></td>
						<td><?php echo $fonction->getFonLibelle();?></td>
					</tr>
				
			</table>
<?php
 } 
}
?>
