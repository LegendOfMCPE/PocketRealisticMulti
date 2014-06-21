<?php

namespace prm;

class Database{
	private $main;
	public function __construct(Main $main){
		$this->main = $main;
	}
}
