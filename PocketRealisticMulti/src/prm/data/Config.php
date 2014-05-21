<?php

namespace prm\data;

class Config implements \ArrayAccess{
	public $data = array();
	public function __construct($path, array $default, $api, $isYAML = false, callable $onAPIVary = "console"){
		if(is_dir($path)){
			throw new \Exception("$path is a directory; unable to create a config file there.");
		}
		$api = (int) $api;
		if(is_file($path)){
			$data = file_get_contents($path);
			$matches = array();
			if(preg_match_all("/#API\\=[0-9]{1,}\n/m", $data, $matches) === 1){
				$loadedAPI = $matches[0][0];
			}
			else{
				trigger_error("API version not found or has multiple results at $path", E_USER_WARNING);
				console("$path will be recreated.");
			}
			$data = preg_replace("/#[0-9A-Za-z]{1,}\n/m", "", $data);
			$this->data = $isYAML ? yaml_parse($data):json_decode($data);
		}
		if(!isset($loadedAPI)){
			file_put_contents($path, "#API=$api\n");
			file_put_contents($path, $isYAML ? yaml_emit($default):json_encode($default), FILE_APPEND | LOCK_EX);
			$this->data = $default;
			$loadedAPI = $api;
		}
		if($loadedAPI < $api){
			if($onAPIVary !== "console"){
				console("[INFO] $path is an outdated config. Adding missing keys", 2);
				foreach($default as $key=>$v){
					if(!isset($this->data[$key])){
						$this->data[$key] = $v; // only add the surface key
					}
				}
			}
			else{
				$this->data = call_user_func($onAPIVary, $this->data, $default);
			}
			$this->api = $api;
		}
	}
	public function offsetExists($k){
		return isset($this->data[$k]);
	}
	public function offsetGet($k){
		return $this->data[$k];
	}
	public function offsetUnset($k){
		return unset($this->data[$k]);
	}
	public funtion offsetSet($k, $v){
		$this->data[$k] = $v;
	}
}
