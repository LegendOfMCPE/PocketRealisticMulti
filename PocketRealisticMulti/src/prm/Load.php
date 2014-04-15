<?php

namespace prm;

use pocketmine\plugin\PluginBase as Pb;
use poxketmine\utils\Config;

class Load extends Pb{
	public static $instance=false;
	public static function get(){
		return $instance;
	}
	public function onLoad(){
		self::$instance=$this;
		$ne=$this->getServer()."plugins/PocketRealisticMulti/loadList.";
		$ext="yml";
		if(is_file($ne."txt"))
			$ext="txt";
		$this->default=array("load-list"=>array(
			"physics"=>array("sound", "gravity", "mechanics"),
			"biology"=>array("health"),
			"society"=>array("economics", "lives")));
		$this->loadList=new Config($ne.$ext, Config::YAML, $this->default);
}
