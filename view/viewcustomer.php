<?php

class Viewcustomer{
	private $page;
	
	/**
	* Constructeur: ajout du header et de la nav dans l'attribut page
	*/
	
	public function __construct(){
		$this->page = file_get_contents('view/html/header.html');
		$this->page .= file_get_contents('view/html/nav.html');	
	}
	public function displayForm(){
		$action = isset($_GET['action'])?$_GET['action']:"";
		$idClient = isset($_GET['idClient'])?$_GET['idClient']:"";
		$societe = isset($_GET['societe'])?$_GET['societe']:"";
		$adresse = isset($_GET['adresse'])?$_GET['adresse']:"";
		$cp = isset($_GET['cp'])?$_GET['cp']:"";
		$ville = isset($_GET['ville'])?$_GET['ville']:"";
		
		//include "html/form.html";
		$content = file_get_contents("view/html/formclient.html");
		$content = str_replace('{action}', $action, $content);
		$content = str_replace('{idClient}', $idClient,$content);
		$content = str_replace('{societe}', $societe,$content);
		$content = str_replace('{adresse}', $adresse,$content);
		$content = str_replace('{cp}', $cp,$content);
		$content = str_replace('{ville}', $ville,$content);
		
		$this->page .=$content;
		$this->displayPage();
	}
	/**
	*Affichage d'un texte reçu par paramètre
	*/
	public function displayMessage($retour){	
		if ($retour){
			$this->page .=  "<p class='alert alert-success'>Opération réussie</p> ";
		}
		else{
		
			$this->page .=  "<p class='alert alert-warning'>Opération ratée</p> ";
		
		}	
		$this->displayPage();
	}
	public function displayList($tableau){
		if(count ($tableau)>0){
			$content ='<div class="table-responsive">'.
			'<table class="table table-striped table-bordered" cellspacing=0 border=1>'.
			'<thead>'.'
					<th>IdClient</th>
					<th>Société</th>
					<th>Adresse</th>
					<th>Code Postal</th>
					<th>Ville</th>
					<th>Modifier</th>
					<th>Supprimer</th>
				'.
			'</thead>'.
			'<tbody>';
			
			foreach($tableau as $element) {
				$content .= "<tr><td>";
				$content .= $element["0"]."</td><td> ";
				$content .= $element["1"]."</td><td> ";
				$content .= $element["2"]."</td><td> ";
				$content .= $element["3"]."</td><td> ";
				$content .= $element["4"]."</td><td> ";
			$url = "index.php?page=customer&action=update&idClient=$element[0]&societe=$element[1]&adresse=$element[2]&cp=$element[3]&ville=$element[4]";
				$content .= "<a href = '$url' ><span class='glyphicon glyphicon-pencil'></span></a></td><td>";
				$content .= "<a href='index.php?page=customer&action=delete&idClient=".$element[0]."'><span class='glyphicon glyphicon-trash'></span></a></td></tr>";
				
			}

			$content .='</tbody></table></div>';
		}
		else{
			$content = "<p class='alert alert-warning>pas de donnée</p>";
		}
		$this->page .=$content;
		$this->displayPage();
	}
	
	private function displayPage(){
		$this->page .= file_get_contents('view/html/footer.html');
		echo $this->page;
		
	}
}

