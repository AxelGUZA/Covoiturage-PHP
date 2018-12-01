<?php
class ProposeManager{

	private $dbo;

	public function __construct($db){
		$this->db =$db;
	}

	public function add($propose){
		$requete = $this->db->prepare(
			'INSERT INTO propose (par_num,per_num,pro_date,pro_time,pro_place,pro_sens) VALUES (:numParcour,:personneNum,:proDate,:proTime,:proPlace,:proSens);');
		$requete->bindValue(':numParcour',$propose->getParNum());
		$requete->bindValue(':personneNum',$propose->getPerNum());
		$requete->bindValue(':proDate',$propose->getProDate());
		$requete->bindValue(':proTime',$propose->getProTime());
		$requete->bindValue(':proPlace',$propose->getProPlace());
		$requete->bindValue(':proSens',$propose->getProSens());


		$retour = $requete->execute();

		return $retour;

	}

	public function getAllPropose(){
		$listePropose = array();

		$sql ='Select par_num,per_num,pro_date,pro_time,pro_place,pro_sens FROM propose ORDER BY 1';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($propose = $requete->fetch(PDO::FETCH_OBJ))
			$listePropose[]  = new Propose($propose);

		 $requete->closeCursor();
            return $listePropose;
	}

	public function getBonneVillePropose($id){
		//echo $id."mon id";
		$listePropose = array();
		$requete = $this->db->prepare('Select par_num,per_num,pro_date,pro_time,pro_place,pro_sens FROM propose WHERE par_num = :id ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		
		while($propose = $requete->fetch(PDO::FETCH_OBJ))
			$listePropose[]  = new Propose($propose);

		 $requete->closeCursor();
            return $listePropose;
	}

	

	public function rechercheTrajet($dDep,$heure,$villeDep,$villeArr,$precision){
		$listePropose = array();

		$requete = $this->db->prepare('Select pro_date, pro_time, pro_place, per_num, prop.par_num FROM propose prop JOIN parcours p ON (prop.par_num=p.par_num)
        WHERE ((pro_sens=0 AND p.vil_num1=:villeDep AND p.vil_num2=:villeArr) OR (pro_sens=1 AND p.vil_num2=:villeDep AND p.vil_num1=:villeArr))
        AND pro_time >= :heure AND (pro_date BETWEEN DATE_SUB(:dmin,INTERVAL :pre DAY) AND  DATE_ADD(:dmax ,INTERVAL :pre DAY))
        GROUP BY pro_date, pro_time, pro_place, per_num, prop.par_num;');

		$requete->bindValue(':heure',$heure);
		$requete->bindValue(':villeDep',$villeDep);
		$requete->bindValue(':villeArr',$villeArr);
		$requete->bindValue(':dmin',$dDep);
		$requete->bindValue(':dmax',$dDep);
		$requete->bindValue(':pre',$precision);
        $requete->execute();

        while($propose = $requete->fetch(PDO::FETCH_OBJ))
			$listePropose[]  = new Propose($propose);

		$requete->closeCursor();
            return $listePropose;
	}

}