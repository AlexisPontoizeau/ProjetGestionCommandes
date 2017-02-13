<?php

class Modelcustomer{
	private $connection;
	
	public function __construct (){
		$this->connectDB();
	}
	private function connectDB(){

		define('SERVER'  ,"localhost");
		define('USER'  ,"root");
		define('PASSWORD'  ,"");
		define('BASE'  ,"exos_mysql");
		
		$this->connection = false;
		try {
			$this->connection = new PDO("mysql:host=".SERVER.";dbname=".BASE,USER,PASSWORD);
			$this->connection->exec('SET NAMES utf8');
		}
		catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
	}
	public function searchCustomers(){
		$tableau = array();
		//etape 2 sélection des données
		if($this->connection){
		$requete = "SELECT * FROM client" ;
			$resultat = $this->connection->query($requete);

			if($resultat){
			$tableau  = $resultat->fetchAll(PDO::FETCH_NUM);
			}
		}
		return $tableau;
	}
	/**
	*Analyse de la zone si elle existe retourne la valeur de la zone
	*Sinon retourne null
	*/
	private function affectzone($zone){
		return isset($zone)?$zone:null;
		}
	public function insertDB(){

			//vérification des données
		$societe =$this->affectzone($_POST['societe']);
		$adresse =$this->affectzone($_POST['adresse']);
		$cp =$this->affectzone($_POST['cp']);
		$ville =$this->affectzone($_POST['ville']);

		$resultat = false;

		// insertion des données
		if ($this->connection){
			$requete =$this->connection->prepare("INSERT INTO client(idClient, societe, adresse, cp, ville) VALUES (NULL, :societe, :adresse, :cp, :ville)");

			$requete->bindParam(':societe', $societe);
			$requete->bindParam(':adresse', $adresse);
			$requete->bindParam(':cp', $cp);
			$requete->bindParam(':ville', $ville);

			$resultat = $requete->execute();
		}
			return $resultat;
	}
	public function updateDB(){
		$idClient =$this->affectzone($_POST['idClient']);
		$societe =$this->affectzone($_POST['societe']);
		$adresse =$this->affectzone($_POST['adresse']);
		$cp =$this->affectzone($_POST['cp']);
		$ville =$this->affectzone($_POST['ville']);

		$resultat = false;
		// insertion des données
		if ($this->connection){
			$requete =$this->connection->prepare("UPDATE client SET societe=:societe, adresse=:adresse, cp=:cp, ville=:ville WHERE idClient=:idClient");
				$requete->bindParam(':idClient', $idClient);
				$requete->bindParam(':societe', $societe);
				$requete->bindParam(':adresse', $adresse);
				$requete->bindParam(':cp', $cp);
				$requete->bindParam(':ville', $ville);

			$resultat = $requete->execute();
		}	
			return $resultat;
	}
	public function deleteDB(){
		
		$idClient = isset($_GET['idClient'])?$_GET['idClient']:0;

		$resultat = false;

		//suppression de la base de donnée
		if($this->connection){
			$requete=$this->connection->prepare("DELETE FROM client WHERE idClient=:idClient");
			$requete->bindParam(":idClient",$idClient);
			$resultat= $requete->execute();
		}
		return $resultat;
	}
}