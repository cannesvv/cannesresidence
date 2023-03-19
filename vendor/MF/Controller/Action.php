<?php

namespace MF\Controller;

abstract class Action {

	protected $view;

	public function __construct() {
		$this->view = new \stdClass();
		date_default_timezone_set('America/Sao_Paulo');
	}

	protected function render($view, $layout = 'layout') {
		$this->view->page = $view;

		if(file_exists("../App/Views/".$layout.".phtml")) {
			require_once "../App/Views/".$layout.".phtml";
		} else {
			$this->content();
		}
	}

	protected function content() {
		$classAtual = get_class($this);

		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);

		$classAtual = strtolower(str_replace('Controller', '', $classAtual));
		//echo $_SERVER['DOCUMENT_ROOT']."App/Views/".$classAtual."/".$this->view->page.".phtml";
		//exit;

		require_once "../../App/Views/".$classAtual."/".$this->view->page.".phtml";
	}
}

?>