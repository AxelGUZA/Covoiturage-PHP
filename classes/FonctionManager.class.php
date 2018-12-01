<?php
class FonctionManager{

	private $dbo;

	public function __construct($db){
		$this->db =$db;
	}

	public function add($Fonction){
		$requete = $this->db->prepare(
			'INSERT INTO Fonction (fon_libelle) VALUES (:fonction);');
		$requete->bindValue(':fonction',$Fonction->getPerNum());



		$retour = $requete->execute();

		return $retour;

	}

	public function getAllFonction(){
		$listeFonction = array();

		$sql ='Select fon_num,fon_libelle FROM Fonction ORDER BY 1';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($Fonction = $requete->fetch(PDO::FETCH_OBJ))
			$listeFonction[]  = new Fonction($Fonction);

		 $requete->closeCursor();
            return $listeFonction;
	}

public function getFonctionById($id){
		//echo $id."mon id";
		$requete = $this->db->prepare('Select fon_num,fon_libelle FROM Fonction Where fon_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		$fonction = $requete->fetch(PDO::FETCH_OBJ);
		$fonctions = new Fonction($fonction);		

            return $fonctions;
	}
	
}

	