<?php

namespace prm;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase as Pb;
use pocketmine\utils\Config;

class Load extends Pb implements Listener{
	const CURRENT_API = 1;
	public static function get(){
		return Server::getInstance()->getPluginManager()->getPlugin("PocketRealisticMulti");
	}
	public function onEnable(){
		$this->registerEvents();
		$this->db = new Database($this);
		$this->saved = new Config($this->getDataFolder()."saved-data.json", self::getDefaultSaved());
		$this->config = new Config($this->getDataFolder()."config.yml", self::getDefaultConfig(), self::CURRENT_API, true);
	}
	private function registerEvents(){
		$pm = $this->getServer()->getPluginManager();
		$pm->registerEvent("pocketmine\\event\\player\\PlayerJoinEvent", $this, EventPriority::NORMAL, new CbEvtExe(array($this, "onJoin")), $this);
	}
	private static function getDefaultSaved(){
		return array(
			"uid" => 0, // unique UserID
		);
	}
	private static function getDefaultConfig(){
		return array(
			
		);
	}
	public function onJoin($event){
		$this->db->getPlayer($event->getPlayer());
	}
}
