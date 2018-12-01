<?php




if(empty($_POST["per_login"]) && empty($_POST["per_pwd"]) && empty($_POST["captch"])){

	$var1 = rand(1,9);
	$var2 = rand(1,9);
	$jpg = ".jpg";
	$_SESSION['nbCaptch'] = $var1 + $var2;
	//echo $_SESSION['nbCaptch'];
	?>

<h1>Pour vous connecter</h1>
	<form action="index.php?page=11" id="insert" method="POST">
		
		Nom d'utilisateur: <input type="text" name="per_login" required/>
			
		Mot de passe : <input type="password" name="per_pwd"  required/>
		
		<img alt="Image avec les variable" src="image/nb/<?php echo $var1.$jpg; ?>">
		+
		<img alt="Image avec les variable" src="image/nb/<?php echo $var2.$jpg; ?>">
		=
		<input type="text" name="captch"  required/>
		

			<input type="submit"  value="Valider">
	</form>

	<?php } else if(!empty($_POST["per_login"]) && !empty($_POST["per_pwd"]) && !empty($_POST["captch"])) {
	$pdo=new Mypdo();
	$personneManager = new PersonneManager($pdo);
	$personne = $personneManager->getConnexionMotDePasse($_POST["per_login"],$_POST["per_pwd"]);
	$salt =  $personneManager->getSalt();
	$pwd = $personne->getPerPwd();
	$login = $personne->getPerLogin();
	$idPers = $personne->getPerNum();

	$coder = sha1(sha1($_POST["per_pwd"]).$salt) ;
	// $test = sha1(sha1("iut").$salt);
	 $captchAVerifTest = $_POST["captch"];
	 $captchDuVerif = $_SESSION['nbCaptch'];
	//$captch = echo $_SESSION['nbCaptch'];

	 // TEST pour le mot de passe
	/*echo " Le premier mdp :";
	print_r($pwd);
	echo "              Mdp emtrer : ".$_POST["per_pwd"]." \n";
	echo " Le deuxieme mdp :";
	print_r($coder);

	echo " Test codage iut :" ;
	print_r($test);*/

	if($login == $_POST["per_login"] && $pwd == $coder && $captchAVerifTest == $captchDuVerif )
	{
		$_SESSION['Connexion']="OK";
		$_SESSION['login'] = $_POST["per_login"];
		$_SESSION['numPerso'] = $idPers;
		header('Location: index.php?page=0');

	}else{
		$_SESSION['Connexion']="KO";
		header('Location: index.php?page=11');

	}

	}
	else {
		echo "erreur";

	}?>