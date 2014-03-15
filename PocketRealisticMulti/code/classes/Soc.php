<?php

class PrmSoc{
	public $econ=false;
	public function __construct(){
		if(class_exists("PrmEcon"))
			$this->econ=new PrmEcon();
	}
}
