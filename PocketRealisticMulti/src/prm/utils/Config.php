<?php

namespace prm\utils;

class Config implements \ArrayAccess{
public $data, $file;
public function __construct($file, $default=array()){
$this->file=$file;
if(!is_file($file)) file_put_contents($file, yaml_emit($default));
$this->data=yaml_parse(file_get_contents($file);
}
public function save(){
file_put_contents($this->file, yaml_emit($this->data));
}
public function reload(){
$this->data=yaml_parse(file_get_contents($this->file));
}
public function offsetExists($key){
return isset($this->data[$key]);
}
public function offsetSet($key, $value){
$this->data[$key]=$value;
}
public function offsetGet($key){
return $this->data[$key];
}
public function &get($key){
return $this->data[$key];
public function offsetUnset($key){
unset($this->data[$key]);
}
}
# TODO tabs