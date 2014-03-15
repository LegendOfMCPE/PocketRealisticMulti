<?php

abstract class PrmCategory{
	public function __construct(){
		foreach(prm_load_list(get_class($this)) as $class){
			$sub=substr($class, 3);
			$sub=str_replace("handler", "", strtolower($shub));
			if(class_exists($class))
				$this->$sub=new $class();
		}
	}
}
