<?php

class Router {

	private $router = null;
	private $page = null;

	public function __construct(&$page) {
		$this->page = $page;
		$this->router = new \Bramus\Router\Router();
		$this->setGlobals();
		$this->addRoutes();
	}
	
	public function run() {
		$this->router->run();
	}

	private function setGlobals() {
		$this->page->setVar('nav_item', $_SESSION['view']);
		$this->page->setVar('type', $_SESSION['view']);
	}

	private function addRoutes() {
		$this->router->get('/', function() {
			$this->page->setVar('menu_item', 'dashboard');
			$this->page->setVar('modifier', '>');
			$this->page->setVar('item_id', '0');
			$this->page->display('item_view');
		});

		$this->router->get('/view/{type}/{itemID}', function($type, $itemID) {
			$this->page->setVar('menu_item', 'view/'.$type.'/'.$itemID);
			$this->page->setVar('modifier', '=');
			$this->page->setVar('item_id', $itemID);
			$this->page->setVar('type', $type);
			$this->page->display('item_view');
		});

		$this->router->get('/viewtype/{type}', function($type) {
			$this->page->setVar('nav_item', $type);
			$this->page->setFrame(false, false);
			$this->page->display('view_changer');
		});

		$this->router->set404(function() {
			$this->page->setFrame(false, false);
			$this->page->display('http_404');
		});
	}

}