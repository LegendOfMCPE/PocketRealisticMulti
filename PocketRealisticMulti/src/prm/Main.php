<?php

namespace prm;

use legendofmcpe\statscore\Table;
use pocketmine\plugin\PluginBase;
use prm\biology\Biology;
use prm\physics\Physics;

class Main extends PluginBase{
	/** @var Module modules */
	private $physics, $biology;
	/** @var Database */
	private $database;
	private $blocks;
	const INITIAL = 0;
	private static $versions = [
		self::INITIAL => "initial release",
	];
	public static function getCurrentVersion(){
		return self::INITIAL;
	}
	public static function getVersionName($version){
		if(isset(self::$versions[$version])){
			return self::$versions[$version];
		}
		return "unknown update";
	}
	public function onEnable(){
		$this->getLogger()->info("Loading PocketRealisticMulti (".self::getVersionName(self::getCurrentVersion()).")...");
		$time = microtime(true) * -1;
		$this->saveDefaultConfig();
		$this->saveResource("block properties.txt");
		$this->blocks = new Table("block properties.txt");
		$this->physics = new Physics($this);
		$this->biology = new Biology($this);
		$this->database = new Database($this);
		$physicsData = $this->getConfig()->get("physics");
		if($physicsData["master"]){
			$this->physics->enable($physicsData);
		}
		$time += microtime(true);
		$time = (string) ($time * 1000);
		$this->getLogger()->info("Done! ($time ms)");
	}
	public function getDataFile($filename){
		return @file_get_contents($this->getDataFolder().$filename);
	}
	public function getBlockProperties(){
		return $this->blocks;
	}
}
