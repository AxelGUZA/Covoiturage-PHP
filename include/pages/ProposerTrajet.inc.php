<h1>Proposer un trajet</h1>

<?php 

if ($_SESSION['Connexion'] == "OK"){

	$pdo=new Mypdo();

if(empty($_POST['vil_num']) && empty($_POST['pro_date']) && empty($_POST['pro_time']) && empty($_POST['pro_place']) ){
			$parcourManager = new ParcoursManager($pdo);
			$allParcours = $parcourManager->getAllParcoursVill();
			//print_r($allParcours);
			$villeManager = new VilleManager($pdo);

			$proposeManager = new ProposeManager($pdo);
			
		?>
		<h2>Ville de depart : </h2>
			<form action="index.php?page=9" id="insert" method="POST">

				<select name="vil_num" id="vil_num">
			        <optgroup label="Choisissez">
						<?php foreach ($allParcours as $ville) { ?>
						<option value= <?php echo $ville->getVilNum1();?>><?php 
						//echo $ville->getVilNum1();
						$laVille = $villeManager->getBonneVille($ville->getVilNum1());
						echo $laVille->getVilNom();

						;?></option>
					<?php }?>
					</optgroup>
				</select>

				<input type="submit"  value="Confimer">

			</form>
		<?php
} else if(!empty($_POST['vil_num']) && empty($_POST['pro_date']) && empty($_POST['pro_time']) && empty($_POST['pro_place']) ) {
	$parcourManager = new ParcoursManager($pdo);
	$allParcours = $parcourManager->getParcourByid($_POST['vil_num']);
	$_SESSION['par_numEntrer']= $parcourManager->getBonParcoursByIdPar_num($_POST['vil_num'])->getParNum();
	$villeManager = new VilleManager($pdo);

	
	$_SESSION['villeEntre'] = $_POST['vil_num']; 
?>
	<form action="index.php?page=9" id="insert" method="POST">


		<div id="ville">
		
		 <p>Ville de depart : <?php echo $villeManager->getBonneVille($_POST['vil_num'])->getVilNom() ?></p>
		 <p>Ville d'arrivee : </p>
		 <select name="vil_num" id="vil_num">
	        <optgroup label="Choisissez">
				<?php foreach ($allParcours as $ville) { ?>
				<option value= <?php echo $ville->getVilNum1(); ?>
				><?php 
				echo  $villeManager->getBonneVille($ville->getVilNum1())->getVilNom();
				//echo $laVille->getVilNom();?> </option>
			<?php } ?>
			</optgroup>
		</select>
		
		</div>

		<div id="heure">
			
			<P>Date de depart :</P>
			<input type="date" name="pro_date" placeholder=<?php echo date('Y-m-d') ?>>



			<P>Heure de depart :</P>
			<input type="time" name="pro_time" placeholder=<?php echo date('H:i:s') ?>>

		</div>

		<div id="pro_place">
			<p>Nombre de place :</p>
			<input type="number" name="pro_place" >

		</div>

			<input type="submit"  value="Valider">
	</form>

<?php
} else if((!empty($_POST['vil_num']) && !empty($_POST['pro_date']) && !empty($_POST['pro_time']) && !empty($_POST['pro_place']) )) {

$personneManager = new PersonneManager($pdo);
$personne =  $personneManager->getPersonneById($_SESSION['numPerso']);
$parcourManager = new ParcoursManager($pdo);
$parcour = $parcourManager->getBonParcoursPourSens($_POST['vil_num']);

if($parcour == "true"){
//	echo "OK";
	$pro_sens = 0;
}else
{
	//echo "KO";
	$pro_sens = 1;
}
$proposeManager = new ProposeManager($pdo);
$propose = new Propose(
					array(	  'par_num' => $_SESSION['par_numEntrer'],
							  'per_num' => $personne->getPerNum(),
							  'pro_date' => $_POST['pro_date'],
							  'pro_time' => $_POST['pro_time'],
							  'pro_place' => $_POST['pro_place'],
							  'pro_sens' => $pro_sens
						)
				);
$retour = $proposeManager->add($propose);
//var_dump($retour);
if($retour !=0){

	//	echo "OK Prose";
	
	}else{
	
		echo "problem";
	
	};
//var_dump($propose);
?>

		<img alt="image Valide" src="image/valid.png"><p>Vous venez de proposer un trajet</p>
<?php
}

}else{

header('Location: index.php?page=0');

}

?>

