<?php
class AvisManager{

	private $dbo;

	public function __construct($db){
		$this->db =$db;
	}

	public function add($avis){
		$requete = $this->db->prepare(
			'INSERT INTO avis (per_num,per_per_num,par_num,avi_comm,avi_note,avi_date) VALUES (:numParcour,:perperNum,:parNum,:avisComm,:avisNote,:avisDate);');
		$requete->bindValue(':numParcour',$avis->getPerNum());
		$requete->bindValue(':perperNum',$avis->getPerPerNum());
		$requete->bindValue(':parNum',$avis->getParNum());
		$requete->bindValue(':avisComm',$avis->getAviComm());
		$requete->bindValue(':avisNote',$avis->getAviNote());
		$requete->bindValue(':avisDate',$avis->getAviDate());


		$retour = $requete->execute();

		return $retour;

	}

	public function getAllAvis(){
		$listeAvis = array();

		$sql ='Select per_num,per_per_num,par_num,avi_comm,avi_note,avi_date FROM avis ORDER BY 1';

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while($avis = $requete->fetch(PDO::FETCH_OBJ))
			$listeAvis[]  = new Avis($avis);

		 $requete->closeCursor();
            return $listeAvis;
	}

	public function getBonAvis($id){
		//echo $id."mon id";
		$requete = $this->db->prepare('Select per_num,per_per_num,par_num,avi_comm,AVG(avi_note) as avi_note ,avi_date FROM avis WHERE per_num = 1 GROUP BY Per_num,per_per_num,par_num,avi_comm,avi_date Order BY avi_date ;');
		$requete->bindValue(':id',$id);
		$requete->execute();
		
			$avis = $requete->fetch(PDO::FETCH_OBJ);
			$bonAvis = new Avis($avis);
            return $bonAvis;
	}


}