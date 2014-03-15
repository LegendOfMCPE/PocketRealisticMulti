<?php

class PrmPhys{
	public $gravity=false, $sound=false;
	public function __construct(){
		if(class_exists("PrmGravityHandler"))
			$this->gravity=new PrmGravityHandler();
		$this->sound=new PrmSoundHandler();
	}
}
