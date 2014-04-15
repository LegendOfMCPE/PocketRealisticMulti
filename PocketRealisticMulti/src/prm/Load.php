<?php

namespace prm;

use pocketmine\plugin\PluginBase as Pb;
use pocketmine\utils\Config;

use prm\datasaver\Players;

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
		$this->loadList=new Config($ne.$ext, Config::YAML);
		if($this->loadList->getAll() === array()){
			$this->loadList->setAll($this->default);
		}
	}
	public function onEnable(){
		$this->players=new Players();
		foreach($this->loadList->get("load-list") as $categ=>$classes){
			foreach($classes as $sclass){
				$sclassname=ucfirst($sclass);
				$className="prm\\$categ\\$sclassname";
				$fieldname=$categ."_".$sclass;
				$this->$fieldname=new $className();
			}
		}
	}
}
