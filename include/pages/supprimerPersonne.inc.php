<?php
	$pdo=new Mypdo();
	$personnesManager = new PersonneManager($pdo);
	$personnes=$personnesManager->getAllPersonne();
	$nbPersonne=$personnesManager->getNbPersonne();


if(empty($_POST["per_num"])){

				?>
<h1>Lister des Personne dans la base </h1>

<p>Actuellement <?php echo $nbPersonne; ?> personnes dans la base</p>


	<table>
		<tr><th>Numéro</th><th>Nom</th><th>Prenom</th><th>Tel</th><th>Mail</th><th>Logim</th><th>Pwd</th></tr>
		<?php
		foreach ($personnes as $personne){ ?>
			<tr>
				<td><?php echo $personne->getPerNum()?></td>
				<td><?php echo $personne->getPerNom();?></td>
				<td><?php echo $personne->getPerPrenom();?></td>
				<td><?php echo $personne->getPerTel();?></td>
				<td><?php echo $personne->getPerMail();?></td>
				<td><?php echo $personne->getPerLogin();?></td>
				<td><?php echo $personne->getPerPwd();?></td>
				<td><a href="index.php?page=4" id="PlusInfo" name="per_num" value=<?php echo $personne->getPerNum();?> ><img src="image/erreur.png"></a></form></td>
			</tr>
		<?php } ?>
		</table>
<?php }else{
var_dump($_POST['per_num']);


} ?>

