<?php

namespace prm\biology;

use prm\Main;
use prm\Module;

class Biology implements Module{
	private $main;
	public function __construct(Main $main){
		$this->main = $main;
	}
}
