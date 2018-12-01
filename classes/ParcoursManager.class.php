<?php
class ParcoursManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
		public function add($parcours){
			$requete = $this->db->prepare(
					'INSERT INTO parcours (par_km,vil_num1,vil_num2) VALUES (:km,:vil_num1,:vil_num2); ');

			$requete->bindValue(':km',$parcours->getParKm());
			$requete->bindValue(':vil_num1',$parcours->getVilNum1());
			$requete->bindValue(':vil_num2',$parcours->getVilNum2());

			$retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
		}

		public function getAllParcours(){
			$listeParcours = array();

			$sql ='select par_num,v.vil_nom as vil_num1,v2.vil_nom as vil_num2, par_km from parcours p join Ville v on p.vil_num1 = v.vil_num join ville v2 on p.vil_num2 = v2.vil_num ORDER BY 1 ';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$listeParcours[] = new parcours($parcours);

				$requete->closeCursor();
				return $listeParcours;
		}

		public function getNbParcours(){
			$sql = 'SELECT COUNT(*) as total FROM parcours';
			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbParcours = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
			return $nbParcours->total;
		}

		public function getParcourByid($id){

			$listeParcours = array();


		$requete = $this->db->prepare('(Select vil_num1 From parcours where vil_num2 = :id) UNION (Select vil_num2 From Parcours where vil_num1 = :id)' );
		$requete->bindValue(':id',$id);
		$requete->execute();
		

		while($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$listeParcours[] = new Parcours($parcours);
		


				$requete->closeCursor();

            return $listeParcours;
		}

		public function getAllParcoursVill()
		{
			$listeParcours = array();

		$requete = $this->db->prepare('Select distinct vil_num1 From parcours UNION SELECT DISTINCT vil_num2 FROM parcours ORDER BY vil_num1 ASC;' );
		$requete->execute();

		while($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$listeParcours[] = new Parcours($parcours);

				$requete->closeCursor();
				return $listeParcours;


		}

		public function getBonParcoursPourSens($id){


		$requete = $this->db->prepare('(Select vil_num1 From parcours where vil_num1 = :id)' );
		$requete->bindValue(':id',$id);
		$requete->execute();
		$nbLigne = $requete->rowCount();
		//var_dump($requete->rowCount());
		if($nbLigne > 0){
			return "true";
		}else
		{
			return "false";
		}
		


		}


		public function getBonParcoursByIdPar_num($id){
				$requete = $this->db->prepare('(Select par_num From parcours where vil_num1 = :id OR vil_num2 = :id)' );
		$requete->bindValue(':id',$id);
		$requete->execute();

		$parcours = $requete->fetch(PDO::FETCH_OBJ);
		$parcour = new Parcours($parcours);

		return $parcour ;

		}

		public function getBonParcoursByIdPar_numVilNum1($id){
				$requete = $this->db->prepare('(Select DISTINCT vil_num2 From Parcours where vil_num1 = :id )' );
		$requete->bindValue(':id',$id);

		$requete->execute();

			while($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$listeParcours[] = new Parcours($parcours);

				$requete->closeCursor();
				return $listeParcours;

		}

		public function getBonParcoursByIdPar_numVilNum2($id){
				$requete = $this->db->prepare('(Select DISTINCT vil_num1  From Parcours where vil_num2 = :id )' );
		$requete->bindValue(':id',$id);

		$requete->execute();

			while($parcours = $requete->fetch(PDO::FETCH_OBJ))
					$listeParcours[] = new Parcours($parcours);

				$requete->closeCursor();
				return $listeParcours;

		}

}