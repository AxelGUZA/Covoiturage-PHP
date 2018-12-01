<h1>Rechercher un trajet</h1>

<?php 

if ($_SESSION['Connexion'] == "OK"){
	$pdo=new Mypdo();
	$villeManager = new VilleManager($pdo);
	$villes = $villeManager->getBonneVilleParcours();
	//print_r($villes);
	
	
if (empty($_POST['vil_num'])){	

?>


<h2>Ville de depart : </h2>

	<form action="index.php?page=10" id="insert" method="POST">

		<select name="vil_num" id="vil_num">
	        <optgroup label="Choisissez">
				<?php foreach ($villes as $ville) { ?>
				<option value= <?php  echo $ville->getVilNum();?>><?php 
				//echo $ville->getVilNum1();
				echo $ville->getVilNom(); ;

				;?></option>
			<?php }?>
			</optgroup>
		</select>

		<input type="submit"  value="Confimer">
	</form>

<?php }

else if (!empty($_POST['vil_num']) && empty($_POST['pro_date']) && empty($_POST['horaire']) && empty($_POST['precision'])){

	$villeManager = new VilleManager($pdo);
	$villeDeDepart= $villeManager->getBonneVille($_POST['vil_num']);
	$laBonneVille = $_POST['vil_num'];
	$_SESSION['vil_num']= $laBonneVille;

	$ville =  $villeManager->getBonneVillePropose($_POST['vil_num']);

	


	//var_dump($_SESSION['vil_num']);
?> <form  action="index.php?page=10"  id="insert" method="POST"> 
	<p>Ville de depart :<?php echo $villeDeDepart->getVilNom();?></p>


	<p>Ville d'arrivee</p>
	<select name="vil_num" id="vil_num">
	        <optgroup label="Choisissez">
				<?php  foreach ($ville as $villes) { ?>
				<option value= <?php echo $villes->getVilNum();?>><?php 
				//echo $ville->getVilNum1();
				echo $villes->getVilNom(); ?></option>
			<?php }?>
			</optgroup>
		</select>


	<p>Date de depart : </p> <input type="date" name="date_dep" value="<?php echo date('Y-m-d'); ?>" class="calendrier"  id="date" required/>

	<p>A partir de : </p>
	<select name="horaire" id="horaire">
	        <optgroup label="Choisissez">

				<?php for ($i=0; $i <= 24 ; $i++) { 
					?>
				<option value= <?php echo $i;?>><?php 
				 echo $i."h"

				;?></option>
			<?php }?>
			</optgroup>
		</select>

		<p>precision :</p><select name="precision" id="precision">
	        <optgroup label="Choisissez">
				
				<option value="1" >Ce jour</option>
				<option value="2" >+/- 1 jours</option>
				<option value="3" >+/- 2 jours</option>
				<option value="4" >+/- 3 jours</option>
			</optgroup>
		</select>

		<input type="submit" name="Valider">
	</form>

<?php } else if(!empty($_POST['precision']) && !empty($_POST['vil_num']) && !empty($_POST['horaire']) && !empty($_POST['date_dep'])) { 

$proposeManager = new ProposeManager($pdo);
$villeManager = new VilleManager($pdo);
$personne = new PersonneManager($pdo);
$avisManager = new AvisManager($pdo);
$propose = $proposeManager->rechercheTrajet($_POST['date_dep'], $_POST['horaire'],$_SESSION['vil_num'],$_POST['vil_num'], $_POST['precision']);

//var_dump($propose);


if(!empty($propose)){
 ?>



			<table>
				<tr><th>Ville de depart</th><th>ville d'arriver</th><th>date depart</th><th>heure depart</th><th>Nombre de place(s)</th><th>Nom du covoitureur</th></tr>	
				<?php foreach ($propose as $ville) {
				$avis = $avisManager->getBonAvis($ville->getPerNum());

				


				
					?>
					<tr>
						<td><?php echo $villeManager->getBonneVille($_SESSION['vil_num'])->getVilNom() ;?></td>
						<td><?php echo $villeManager->getBonneVille($_POST['vil_num'])->getVilNom() ; ?></td>
						<td><?php echo $ville->getProDate() ;?></td>
						<td><?php echo $ville->getProTime() ;?></td>
						<td><?php echo $ville->getProPlace() ;?></td>
						
						<td title="<?php echo "Moyenne des avis : ".round($avis->getAviNote())." Dernier avis : ".$avis->getAviComm()?>"><?php echo $personne->getPersonneById($ville->getPerNum())->getPerNom()." ".$personne->getPersonneById($ville->getPerNum())->getPerPrenom(); ?></td>
					</tr>
				<?php } ?>
				
			</table>
<?php }else { ?> 


<img alt="Eurreur Image" src="image/erreur.png"><p>Desole, pas de trajet disponible</p>

<?php } }
}else{

//header('Location: index.php?page=0');

}

?>

