<?php


if(empty($_POST["choix"]) AND empty($_POST["div_num"]) AND empty($_POST["dep_num"]) AND empty($_POST["per_tel"]) AND empty($_POST["fon_num"])){
	
	?>

	<h1>Ajouter un parcours</h1>
	<form action="index.php?page=1" id="insert" method="POST">
		<div id="blockG">
		Nom: <input type="text" name="per_nom" required/>
			
		Telephone: <input type="tel" name="per_tel"  required/>
		
		Login: <input type="text" name="per_login"  required/>
		</div>
		<div id="blockD">
		Prenom: <input type="text" name="per_prenom"  required/>

		Mail: <input type="email" name="per_mail"  required/>

		Mot de passe: <input type="password" name="per_pwd"  required/>
		</div>
		Categorie: <input type="radio" name="choix" value="Etudiant" id="Etudiant" /> <label for="Etudiant">Etudiant</label>
		<input type="radio" name="choix" value="Personnel" id="Personnel" /> <label for="Personnel">Personnel</label>


			<input type="submit"  value="Valider">
	</form>


	<?php

}
else if (!empty($_POST["choix"]) AND $_POST["choix"] =="Etudiant")

{

	$pdo=new Mypdo();
	$personneManager = new PersonneManager($pdo);
	$personne = new Personne($_POST);
	$retour = $personneManager->add($personne);
	$idPersonne= $personneManager->retourID();
	$_SESSION['idDePersonne'] = $idPersonne;


	

	$divisionManager = new DivisionManager($pdo);
	$division = $divisionManager->getAllDivision();

	//$pdo2 = new Mypdo();
	$departementManager = new DepartementManager($pdo);
	$departement = $departementManager->getAllDepartement();
	
		
		 ?>
		<form action="index.php?page=1" id="insert" method="POST">

			<label for="div_num">Annee :</label>
				<select name="div_num" id="div_num">
			        <optgroup label="Annee">
			        	<?php foreach ($division as $divisions) { ?>
			        	
						<option value=<?php echo $divisions->getDivNum();?> ><?php echo $divisions->getDivNom();?></option>
					<?php } ?>
					</optgroup>
				</select>


			<label for="dep_num">Departement :</label>
				<select name="dep_num" id="dep_num">
			        <optgroup label="Departement">
			        	<?php foreach ($departement as $departements)  { ?>
			        	
						<option value=<?php echo $departements->getDepNum();?> ><?php echo $departements->getDepNom();?></option>
					<?php } ?>
					</optgroup>
				</select>


			
		
			<input type="submit"  value="Valider">
		</form>
		
	<?php
	
	

}

else if(empty($_POST["choix"]) AND  !empty($_POST["div_num"]) AND !empty($_POST["dep_num"])){


	$pdo=new Mypdo();
	$etudiantManager = new EtudiantManager($pdo);
	$etudiant = new Etudiant(
						array('per_num' => $_SESSION['idDePersonne'],
							  'dep_num' => $_POST['dep_num'],
							  'div_num' => $_POST['div_num']
						)
					);
	$retour = $etudiantManager->add($etudiant);


if($retour !=0){
		?>
		<h1>Ajouter un Etudiant</h1>
		<img alt="Image valid" src="image/valid.png"><p>Le Etudiant a bien ete ajoute</p>
	<?php
	
	}else{
	
		echo "problem";
	
	}


}

else if (!empty($_POST["choix"]) AND $_POST["choix"] =="Personnel")

{

	$pdo=new Mypdo();
	$personneManager = new PersonneManager($pdo);
	$personne = new Personne($_POST);
	$retour = $personneManager->add($personne);
	$idPersonne= $personneManager->retourID();
	$_SESSION['idDePersonne'] = $idPersonne;

	

	$fonctionManager = new FonctionManager($pdo);
	$fonctions = $fonctionManager->getAllFonction();
	

	
		?>

		<form action="index.php?page=1" id="insert" method="POST">

			Telephone professionnel: <input type="tel" name="per_tel"  required/>

			<label for="fon_num">Fonction :</label>
				<select name="fon_num" id="fon_num">
			        <optgroup label="Fonction">
			        	<?php foreach ($fonctions as $fonction)  { ?>
			        	
						<option value=<?php echo $fonction->getFonNum();?> ><?php echo $fonction->getFonLibelle();?></option>
					<?php } ?>
					</optgroup>
				</select>
			
		
			<input type="submit"  value="Valider">
		</form>
		
	<?php
	
	
}

else if(empty($_POST["choix"]) AND  !empty($_POST["per_tel"]) AND !empty($_POST["fon_num"])){

	$pdo=new Mypdo();
	$salarieManager = new SalarieManager($pdo);
	$salarie = new Salarie(
						array('per_num' => $_SESSION['idDePersonne'],
							  'sal_telprof' => $_POST['per_tel'],
							  'fon_num' => $_POST['fon_num']
						)
	);

	$retour = $salarieManager->add($salarie);


if($retour !=0){
		?>
		<h1>Ajouter un salarier</h1>
		<img alt="Image valide" src="image/valid.png"><p>Le salarier a bien ete ajoute</p>
	<?php
	
	}else{
	
		echo "problem";
	
	}


}
 ?>
