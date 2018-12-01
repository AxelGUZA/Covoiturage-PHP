<?php

if(empty($_POST["par_km"])){
	?>

	<h1>Ajouter un parcours</h1>
	<form action="index.php?page=5" id="insert" method="POST">
		<?php 
			$pdo=new Mypdo();
			//$ParcoursManage= new ParcoursManager($pdo);
			//$Parcours = $ParcoursManage->getAllParcours();
			$villeManager = new VilleManager($pdo);
			$villes=$villeManager->getAllVille();
			//print_r($Parcours);
			//print_r($villes);
			
			
		?>

		<label for="vil_num1">Ville 1:</label>
		<select name="vil_num1" id="vil_num1">
	        <optgroup label="Ville1">
	        	<?php foreach ($villes as $ville) { ?>
	        	
				<option value=<?php echo $ville->getVilNum();?> ><?php echo $ville->getVilNom();?></option>
			<?php }?>
			</optgroup>
		</select>

		<label for="vil_num2">Ville 2:</label>
		<select name="vil_num2" id="vil_num2">
	        <optgroup label="Ville2">
				<?php foreach ($villes as $ville) { ?>
				<option value= <?php echo $ville->getVilNum();?>><?php echo $ville->getVilNom();?></option>
			<?php }?>
			</optgroup>
		</select>
 	
		Nombre de kilometre(s): <input type="text" name="par_km">
		<input type="submit"  value="Valider">

	</form>


	<?php

}
else

{
	$pdo=new Mypdo();
	$ParcoursManage= new ParcoursManager($pdo);
	$Parcours = new Parcours($_POST);
	$retour= $ParcoursManage->add($Parcours);
	

	if($retour !=0){
		?>
		<h1>Ajouter un parcours</h1>
		<img alt="image valide" src="image/valid.png"><p>Le parcours a ete ajoutee</p>
	<?php
	
	}else{
	
		echo "problem";
	
	}
}
 ?>