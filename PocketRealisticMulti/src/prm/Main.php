<?php

namespace prm;

use pocketmine\plugin\PluginBase;
use prm\biology\Biology;
use prm\physics\Physics;

class Main extends PluginBase{
	/** @var Module modules */
	private $physics, $biology;
	/** @var Database */
	private $database;
	const INITIAL = 0;
	private static $versions = [
		INITIAL => "initial release",
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
		$this->saveResource("config.yml");
		$this->physics = new Physics($this);
		$this->biology = new Biology($this);
		$this->database = new Database($this);
		$time += microtime(true);
		$time = (string) ($time * 1000);
		$this->getLogger()->info("Done! ($time ms)");
	}
}
