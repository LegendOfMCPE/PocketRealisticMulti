<?php

namespace prm\physics;

use pocketmine\event\player\PlayerChatEvent;
use pocketmine\level\Position;
use pocketmine\utils\Config;
use prm\Main;
use prm\Module;
use prm\physics\sound\Sound;

class Physics implements Module{
	private $main;
	private $enabled = false;
	private $sound;
	/** @var Config */
	private $config = null;
	public function __construct(Main $main){
		$main->saveResource("physics.yml");
		$this->main = $main;
		$this->server = $main->getServer();
		$this->sound = new Sound($main);
	}
	public function enable(array $set){
		if($this->enabled === true){
			return;
		}
		$this->enabled = true;
		$this->config = new Config($this->main->getDataFolder()."physics.yml", Config::YAML);
		if($set["sound waves"]){
			$this->sound->enable($this->getConfig()->get("sound waves"));
		}
	}
	public function disable(){
		if($this->enabled === false){
			return;
		}
		$this->enabled = false;
		$this->config = null;
	}
	public function isEnabled(){
		return $this->enabled;
	}
	public function getConfig(){
		return $this->config;
	}
}
