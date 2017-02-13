<?php
	include "model/modelcustomer.php";
	include "view/viewcustomer.php";
	
class Controllercustomer{	
	private $view;
	private $model;
	
	public function __construct(){
		$this->view = new Viewcustomer();
		$this->model = new Modelcustomer();
	}
	
	/**
	*Affichage de la liste des commandes
	*/
	public function display(){
		$list = $this->model->searchCustomers();
		$this->view->displayList($list);
		
		//$this->view->displayMessage("<h1>Liste des commandes</h1>");
		
	}
	/**
	*Ajout d'une commande 
	*/
	public function add(){
		$tableCustomer = $this->model->searchCustomers();
		//$this->view->displayMessage("<h1>Ajout d'une commande</h1>");
		$this->view->displayForm($tableCustomer);	
	}
	public function addDB(){
		$result = $this->model->insertDB();
		$this->view->displayMessage($result);
	}
	/**
	*Modification d'une commande
	*/
	public function update(){
		
		$tableCustomer = $this->model->searchCustomers();
		$this->view->displayForm($tableCustomer);
	}
	public function updateDB(){
		$result = $this->model->updateDB();
		$this->view->displayMessage($result);
	}
	/**
	*Suppression d'une commande
	*/
	public function delete(){
		$result = $this->model->deleteDB();
		$this->display();
		//$this->view->displayMessage("<h1>Suppression d'une commande</h1>");
		
	}
	
	/**
	*Affichage de l'erreur
	*/
	public function displayError($codeError){
		$this->view->displayMessage("<h1>Erreur $codeError</h1>");
	}
}