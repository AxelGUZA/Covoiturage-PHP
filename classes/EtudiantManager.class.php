<?php
class EtudiantManager{
	private $dbo;

	public function __construct($db){
		$this->db =$db;
	}

	public function add($etudiant){
		$requete = $this->db->prepare(
			'INSERT INTO etudiant (per_num,dep_num,div_num) VALUES (:personne,:departement,:division);');
		$requete->bindValue(':personne',$etudiant->getPerNum());
		$requete->bindValue(':departement',$etudiant->getDepNum());
		$requete->bindValue(':division',$etudiant->getDivNum());


		$retour = $requete->execute();

		return $retour;

	}

	public function getAllEtudiant(){
		$listeEtudiant = array();

		$sql ='Select per_num,dep_num,div_num FROM etudiant ORDER BY 1';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($etudiant = $requete->fetch(PDO::FETCH_OBJ))
			$listeEtudiant[]  = new Etudiant($etudiant);

		 $requete->closeCursor();
            return $listeEtudiant;
	}

	public function getBonEtudiant($id){
		//echo $id."mon id";
		$requete = $this->db->prepare('Select per_num,dep_num,div_num FROM etudiant WHERE per_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		$etudiant = $requete->fetch(PDO::FETCH_OBJ);
		$etudiants = new Etudiant($etudiant);		

            return $etudiants;
	}

	public function getBonEtudiantBool($id){
		//echo $id."mon id";
			$requete = $this->db->prepare('Select per_num FROM etudiant WHERE per_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		//var_dump($requete->rowCount());
		if ($requete->rowCount() < 0) {
			return "false";
		}else{
			return "true";
		}

	}
}