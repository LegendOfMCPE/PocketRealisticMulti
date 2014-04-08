<?php

abstract class PrmCategory{
	public function __construct(){
		foreach(prm_load_list(get_class($this)) as $class){
			$sub=substr($class, 3);
			$sub=str_replace(array("handler", "api"), array("", ""), strtolower($sub));
			if(class_exists($class))
				$this->$sub=new $class();
		}
		$this->dir=FILE_PATH."plugins/PocketRealisticMulti/".get_class($this)."/";
		@mkdir($this->file);
	}
}
