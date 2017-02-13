<?php

class Vieworder{
	
	private $page;
	
	/**
	* Constructeur: ajout du header et de la nav dans l'attribut page
	*/
	
	public function __construct(){
		$this->page = file_get_contents('view/html/header.html');
		$this->page .= file_get_contents('view/html/nav.html');	
	}
	public function displayForm($tableOrder){
		$action = isset($_GET['action'])?$_GET['action']:"";
		$id = isset($_GET['id'])?$_GET['id']:"";
		$date = isset($_GET['date'])?$_GET['date']:"";
		$montantHT = isset($_GET['montantHT'])?$_GET['montantHT']:"";
		$idClient = isset($_GET['idClient'])?$_GET['idClient']:"";
		//include "html/form.html";
		$content = file_get_contents("view/html/formcommande.html");
		$content = str_replace('{action}', $action, $content);
		$content = str_replace('{id}', $id,$content);
		$content = str_replace('{date}', $date,$content);
		$content = str_replace('{montantHT}', $montantHT,$content);
		$content = str_replace('{idClient}', $idClient,$content);
		
		$listeIdClient="";
		foreach ($tableOrder as $client){
			$selected = ($client[0] == $idClient)?"selected":"";
			$listeIdClient .="<option value='$client[0]'$selected>$client[1]</option>";
		}
		$content = str_replace('{listeIdClient}', $listeIdClient, $content);
		$this->page .=$content;
		$this->displayPage();
	}
	/**
	*Affichage d'un texte reçu par paramètre
	*/
	public function displayMessage($retour){	
		if ($retour){
			$this->page .=  "<p class='alert alert-success'>Opération réussi</p> ";
		}
		else{
		
			$this->page .=  "<p class='alert alert-warning'>Opération raté</p> ";
		
		}	
		$this->displayPage();
	}
	public function displayList($tableau){
		if(count ($tableau)>0){
			$content ='<div class="table-responsive">'.
			'<table class="table table-striped table-bordered" cellspacing=0 border=1>'.
			'<thead>'.'
					<th>Id</th>
					<th>Date</th>
					<th>MontantHT</th>
					<th>IdClient</th>
					<th>Modifier</th>
					<th>Supprimer</th>
				'.
			'</thead>'.
			'<tbody>';
			
			$somme = 0;
			
			foreach($tableau as $element) {
				$content .= "<tr><td>";
				$content .= $element["0"]."</td><td> ";
				$content .= $element["1"]."</td><td> ";
				$content .= $element["2"]."</td><td> ";
				$content .= $element["4"]."</td><td> ";
			$url = "index.php?action=update&id=$element[0]&date=$element[1]&montantHT=$element[2]&idClient=$element[3]";
				$content .= "<a href = '$url' ><span class='glyphicon glyphicon-pencil'></span></a></td><td>";
				$content .= "<a href='index.php?action=delete&id=".$element[0]."'><span class='glyphicon glyphicon-trash'></span></a></td></tr>";
				
				$somme+= $element[2];
				
			}
			$content .= "<tr><td colspan=2> Total</td><td>$somme</td></tr>";
			$moyenne = round ($somme/count($tableau),2);
			$content .= "<tr><td colspan=2> Montant moyen</td><td>$moyenne</td></tr>";
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