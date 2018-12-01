<?php
class VilleManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}
		public function add($ville){
			$requete = $this->db->prepare(
							'INSERT INTO ville (vil_nom) VALUES (:nom);');
			
			$requete->bindValue(':nom',$ville->getVilNom());

			$retour=$requete->execute();
				//var_dump($requete->debugDumpParams());
					return $retour;
		}

		public function getAllVille(){
			$listeVille = array();

			$sql = 'select vil_num, vil_nom From Ville ORDER BY 2';

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while($ville= $requete->fetch(PDO::FETCH_OBJ))
					$listeVille[] = new Ville($ville);

				$requete->closeCursor();
				return $listeVille;
		}

		public function getNBVille()
		{

			$sql = 'SELECT COUNT(*) AS Total From ville';
			$requete = $this->db->prepare($sql);
			$requete->execute();

			$nbVille = $requete->fetch(PDO::FETCH_OBJ);
			$requete->closeCursor();
			return $nbVille->Total;
		}


		public function getBonneVille($id){

		$requete = $this->db->prepare('Select vil_num, vil_nom FROM Ville WHERE vil_num = :id;');
		$requete->bindValue(':id',$id);
		$requete->execute();

		$ville = $requete->fetch(PDO::FETCH_OBJ);
		$villes = new Ville($ville);

		return $villes;

	}

	public function getBonneVilleNom($id){

		$requete = $this->db->prepare('Select vil_num, vil_nom FROM Ville WHERE vil_nom = :id;');
		$requete->bindValue(':id',$id);
		$requete->execute();

		$ville = $requete->fetch(PDO::FETCH_OBJ);
		$villes = new Ville($ville);

		return $villes;

	}


		public function getBonneVillePropose($id){
			$listeVille = array();

		$requete = $this->db->prepare('select vil_num, vil_nom FROM ville WHERE vil_num IN(SELECT vil_num1 FROM parcours WHERE vil_num2=:id)
		OR vil_num IN(SELECT vil_num2 FROM parcours WHERE vil_num1=:id);');
		$requete->bindValue(':id',$id);
		$requete->execute();
		
		while($ville= $requete->fetch(PDO::FETCH_OBJ))
					$listeVille[] = new Ville($ville);

				$requete->closeCursor();
				return $listeVille;
	}


	

		public function getBonneVilleParcours(){
			$listeVille = array();

			$requete = $this->db->prepare('select vil_num, vil_nom from parcours par join propose pr on par.par_num=pr.par_num
			join ville vil on par.vil_num1 = vil.vil_num where pro_sens = 0 group by vil_num
            
            	union
			select vil_num, vil_nom from parcours par join propose pro on par.par_num = pro.par_num
			join ville vil on par.vil_num2 = vil.vil_num where pro_sens=1 group by vil_num;' );
			$requete->execute();

	
			while($ville= $requete->fetch(PDO::FETCH_OBJ))
					$listeVille[] = new Ville($ville);

				$requete->closeCursor();
				return $listeVille;
			
		}


	
}