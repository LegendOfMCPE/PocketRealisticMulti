<?php

namespace prm\physics;

use prm\Main;
use prm\Module;

class Physics implements Module{
	private $main;
	public function __construct(Main $main){
		$this->main = $main;
	}
}
