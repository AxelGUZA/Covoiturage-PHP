<?php
class Personne{
	private $per_num;
	private $per_nom;
	private $per_prenom;
	private $per_tel;
	private $per_mail;
	private $per_login;
	private $per_pwd;

	public function __construct($valeurs = array()){
		if(!empty($valeurs))
			$this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur) {
					switch ($attribut) {
						case 'per_num': $this->setPerNum($valeur);break;
						case 'per_nom': $this->setPerNom($valeur);break;
						case 'per_prenom': $this->setPerPrenom($valeur);break;
						case 'per_tel': $this->setPerTel($valeur);break;
						case 'per_mail': $this->setPerMail($valeur);break;
						case 'per_login': $this->setPerLogin($valeur);break;
						case 'per_pwd': $this->setPerPwd($valeur);break;

					}
			}
	}

	public function getPerNum(){
		return $this->per_num;
	}

	public function setPerNum($id){
		$this->per_num=$id;
	}

	public function getPerNom(){
		return $this->per_nom;
	}

	public function setPerNom($id){
		$this->per_nom=$id;
	}

	public function getPerPrenom(){
		return $this->per_prenom;
	}

	public function setPerPrenom($id){
		$this->per_prenom=$id;
	}

	public function getPerTel(){
		return $this->per_tel;
	}

	public function setPerTel($id){
		$this->per_tel=$id;
	}

	public function getPerMail(){
		return $this->per_mail;
	}

	public function setPerMail($id){
		$this->per_mail=$id;
	}

	public function getPerLogin(){
		return $this->per_login;
	}

	public function setPerLogin($id){
		$this->per_login=$id;
	}

	public function getPerPwd(){
		return $this->per_pwd;
	}

	public function setPerPwd($id){
		$this->per_pwd=$id;
	}

	
	
}