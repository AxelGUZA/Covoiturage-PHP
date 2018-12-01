<?php
class Departement{
	private $dep_num;
	private $dep_nom;
	private $vil_num;

	public function __construct($valeurs = array()){
		if(!empty($valeurs))
			$this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur) {
					switch ($attribut) {
						case 'dep_num': $this->setDepNum($valeur);break;
						case 'dep_nom': $this->setDepNom($valeur);break;
						case 'vil_num': $this->setVilNum($valeur);break;

					}
			}
	}

	public function getDepNum(){
		return $this->dep_num;
	}

	public function setDepNum($id){
		$this->dep_num=$id;
	}

	public function getDepNom(){
		return $this->dep_nom;
	}

	public function setDepNom($id){
		$this->dep_nom=$id;
	}

	public function getVilNum(){
		return $this->vil_num;
	}

	public function setVilNum($id){
		$this->vil_num=$id;
	}


	
	
}
