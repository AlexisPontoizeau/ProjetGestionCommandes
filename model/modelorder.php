<?php

class Modelorder{
	
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
	public function searchOrders(){
		$tableau = array();
		
		if ($this->connection){

			$requete = "SELECT id, date, montantHT,commande.idClient, societe FROM commande JOIN client ON commande.idClient = client.idClient" ;
			$resultat=$this->connection->query($requete);
			if($resultat){
				$tableau=$resultat->fetchAll(PDO::FETCH_NUM);
			}

		}
			return $tableau;
	}
	public function searchCustomer(){
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
		$date =$this->affectzone($_POST['date']);
		$montantHT =$this->affectzone($_POST['montantHT']);
		$idClient = $this->affectzone($_POST['idClient']);

		$result = false;

		// insertion des données
		if ($this->connection){
			$requete =$this->connection->prepare("INSERT INTO commande(id, date, montantHT, idClient) VALUES (NULL, :date, :montantHT, :idClient)");

			$requete->bindParam(':date', $date);
			$requete->bindParam(':montantHT', $montantHT);
			$requete->bindParam(':idClient', $idClient);

			$result = $requete->execute();
		}
			return $result;
	}
	public function updateDB(){
		$id =$this->affectzone($_POST['id']);
		$date =$this->affectzone($_POST['date']);
		$montantHT =$this->affectzone($_POST['montantHT']);
		$idClient =$this->affectzone($_POST['idClient']);

		$result = false;
		// insertion des données
		if ($this->connection){
			$requete =$this->connection->prepare("UPDATE commande SET date=:date, montantHT=:montantHT, idClient=:idClient WHERE id=:id");

			$requete->bindParam(':date', $date);
			$requete->bindParam(':montantHT', $montantHT);
			$requete->bindParam(':idClient', $idClient);
			$requete->bindParam(':id', $id);

			$result = $requete->execute();
		}	
			return $result;
	}
	public function deleteDB(){
		
		//vérification de l'identifiant
		$id = isset($_GET['id'])?$_GET['id']:0;

		$resultat = false;
	//suppression de la base de donnée
		if($this->connection){
			$requete=$this->connection->prepare("DELETE FROM commande WHERE id=:id");
			$requete->bindParam(":id",$id);
			$resultat= $requete->execute();
		}
		return $resultat;
		}
	
}