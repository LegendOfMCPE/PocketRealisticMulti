<?php

namespace prm;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase as Pb;

use prm\data\Config;
use prm\data\Database;
use prm\data\PlayerDatabase;
use prm\utils\CbEvtExe;

class Load extends Pb implements Listener{
	const CURRENT_API = 1;
	public static function get(){
		return Server::getInstance()->getPluginManager()->getPlugin("PocketRealisticMulti");
	}
	public function onEnable(){
		$this->registerEvents();
		$this->db = new Database($this);
		$this->saved = new Config($this->getDataFolder()."saved-data.json", self::getDefaultSaved());
		$this->userConfig = new Config($this->getDataFolder()."config.yml", self::getDefaultConfig(), self::CURRENT_API, true);
	}
	private function registerEvents(){
		$pm = $this->getServer()->getPluginManager();
		$pm->registerEvents($this, $this);
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
	public function onJoin(PlayerJoinEvent $event){
		$this->db->pInit($event->getPlayer());
	}
	public function onQuit(PlayerQuitEvent event){
		$this->db->pFine($event->getPlayer());
	}
}
