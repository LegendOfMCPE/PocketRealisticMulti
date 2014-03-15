<?php

class PrmBio{
	public function __construct(){
		if(class_exists("PrmHealthHandler"))
			$this->health=new PrmHealthHandler();
	}
}
