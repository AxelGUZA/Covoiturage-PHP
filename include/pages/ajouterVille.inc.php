<?php
if(empty($_POST["vil_nom"])){
	?>

	<h1>Ajouter une ville</h1>
	<form action="index.php?page=7" id="insert" method="POST">
		Nom: <input type="text" name="vil_nom">
		<input type="submit"  value="Valider">

	</form>


	<?php

}
else

{
	$pdo=new Mypdo();
	$villeManage= new VilleManager($pdo);
	$bonneVil = $villeManage->getBonneVilleNom($_POST["vil_nom"]);

	
	
	if( empty($bonneVil->getVilNom())){
	$ville = new Ville($_POST);
	$retour= $villeManage->add($ville);
	

	if($retour !=0){
		?>
		<h1>Ajouter une ville</h1>
		<img alt="Image valide" src="image/valid.png"><p>La ville "<?php echo $ville->getVilNom(); ?>" a ete ajoutee</p>
	<?php } else {
		echo "problem";
	 }
	
	}else{
	
	?><h1>Ajouter une ville</h1>
		<img alt="Image erreur" src="image/erreur.png"><p>La ville "<?php echo $bonneVil->getVilNom(); ?>" existe deja</p>
		
	<?php
	}
}
 ?>
