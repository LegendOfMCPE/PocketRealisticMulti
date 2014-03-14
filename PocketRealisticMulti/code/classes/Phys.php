<?php

class PrmPhys{
	public $gravity=false, $sound=false;
	public function __construct(){
		$this->gravity=new PrmGravityHandler();
		$this->sound=new PrmSoundHandler();
	}
}
