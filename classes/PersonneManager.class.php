<?php
class PersonneManager{

	private $dbo;
	

	public function __construct($db){
		$this->db=$db;
	}
	

	public function add($personne){
		$salt = "48@!alsd";

		$requete = $this->db->prepare('INSERT INTO Personne (per_nom,per_prenom,per_tel,per_mail,per_login,per_pwd) VALUES (:nom,:prenom,:tel,:mail,:login,:pwd);');

		$requete->bindValue(':nom',$personne->getPerNom());
		$requete->bindValue(':prenom',$personne->getPerPrenom());
		$requete->bindValue(':tel',$personne->getPerTel());
		$requete->bindValue(':mail',$personne->getPerMail());
		$requete->bindValue(':login',$personne->getPerLogin());
		$requete->bindValue(':pwd',sha1(sha1($personne->getPerPwd()).$salt));

		$retour = $requete->execute();

		return $retour;
	}

	public function retourID(){

		$id = $this->db->lastInsertId();
		return $id;

	}


	public function getAllPersonne(){
		$listePersonne = array();

		$sql ='Select per_num,per_nom,per_prenom,per_tel,per_mail,per_login,per_pwd FROM Personne';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($personne = $requete->fetch(PDO::FETCH_OBJ))
			$listePersonne[]  = new Personne($personne);

		 $requete->closeCursor();
            return $listePersonne;
	}

	public function getNbPersonne(){
			$sql = 'SELECT COUNT(*) as total FROM personne';
			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbParcours = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
			return $nbParcours->total;
		}

		public function getPersonneById($id){
			//echo "mon id".$id;
		$requete = $this->db->prepare('Select per_num,per_nom,per_prenom,per_tel,per_mail FROM personne WHERE per_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		$personne = $requete->fetch(PDO::FETCH_OBJ);
			$LaPersonne  = new Personne($personne);
            return $LaPersonne;

		}

		public function getConnexionMotDePasse($login,$mdp){
			$salt = "48@!alsd";
			$requete = $this->db->prepare('Select per_num,per_login,per_pwd  FROM personne WHERE per_login = :login AND per_pwd = :mdp ;');
			$requete->bindValue(':login',$login);
			$requete->bindValue(':mdp',sha1(sha1($mdp).$salt));
			$requete->execute();
			var_dump($requete->rowCount());

			$personne = $requete->fetch(PDO::FETCH_OBJ);
			$LaPersonne  = new Personne($personne);
            return $LaPersonne;
/*
ICI il va falloir comparer le mdp avec l'autre avec le double salt
*/
		}

		public function getSalt()
		{
			$salt = "48@!alsd";
			return  $salt;
		}
}