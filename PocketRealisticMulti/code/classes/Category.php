<?php

abstract class PrmCat{
public function __construct(){
foreach(prm_load_list(get_class($this)) as $class){
$sub=substr($class, 3);
if(class_exists($class))
$this->$sub=new $class();
}
}
}
