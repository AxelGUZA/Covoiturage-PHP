<?php
class SalarieManager{
	
	private $dbo;

	public function __construct($db){
		$this->db =$db;
	}

	public function add($salarie){
		$requete = $this->db->prepare(
			'INSERT INTO salarie (per_num,sal_telprof,fon_num) VALUES (:personne,:tel,:fonction);');
		$requete->bindValue(':personne',$salarie->getPerNum());
		$requete->bindValue(':tel',$salarie->getSalTelprof());
		$requete->bindValue(':fonction',$salarie->getFonNum());


		$retour = $requete->execute();

		return $retour;

	}

	public function getAllSalarie(){
		$listeSalarie = array();

		$sql ='Select per_num,sal_telprof,fon_num FROM salarie ORDER BY 1';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($salarie = $requete->fetch(PDO::FETCH_OBJ))
			$listeSalarie[]  = new Salarie($salarie);

		 $requete->closeCursor();
            return $listeSalarie;
	}

	public function getBonSalarie($id){
		//echo $id."mon id";
		$requete = $this->db->prepare('Select per_num,sal_telprof,fon_num FROM salarie WHERE per_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		$salarie = $requete->fetch(PDO::FETCH_OBJ);
		$salarie = new Salarie($salarie);		

            return $salarie;
	}
}