<?php

namespace prm\society;

use prm\Main;
use prm\Module;

class Society implements Module{
	private $main;
	private $enabled = false;
	private $vehicles;
	private $config;
	public function __construct(Main $main){
		$main->saveResource("society.yml");
		$this->main = $main;
		$this->server = $main->getServer();
	}
	public function enable(array $data){
		if($this->enabled){
			return;
		}
		$this->enabled = true;
		if($data["vehicles"]){

		}
	}
}
