<?php
class DepartementManager{
	private $dbo;

	public function __construct($db){
		$this->db =$db;
	}

	public function add($departement){
		$requete = $this->db->prepare(
			'INSERT INTO departement (dep_num,dep_nom,vil_num) VALUES (:nom,:numeroVil);');

		$requete->bindValue(':nom',$departement->getDepNom());
		$requete->bindValue(':numeroVil',$departement->getVilNum());


		$retour = $requete->execute();

		return $retour;

	}

	public function getAllDepartement(){
		$listedepartement = array();

		$sql ='Select dep_num,dep_nom,vil_num FROM departement ORDER BY 1';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($departement = $requete->fetch(PDO::FETCH_OBJ))
			$listedepartement[]  = new Departement($departement);

		 $requete->closeCursor();

            return $listedepartement;
	}


	public function getDepartementById($id){
		//echo "mon id departments ".$id;
		$requete = $this->db->prepare('Select dep_nom, vil_num FROM Departement Where dep_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();

		$departement = $requete->fetch(PDO::FETCH_OBJ);
		$departments = new Departement($departement);
		/*var_dump($departement);
		var_dump($departments);*/
		return $departments;
	}


}

