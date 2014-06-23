<?php

namespace prm\biology;

use prm\Main;
use prm\Module;

class Biology implements Module{
	private $main;
	private $enabled = false;
	public function __construct(Main $main){
		$this->main = $main;
	}
	public function enable(array $data){
		$this->enabled = true;
	}
	public function disable(){
		$this->enabled = false;
	}
}
