<?php

namespace prm\datasaver;

use pemapmodder\utils\CallbackEventExe as CbEvtExe;

use pocketmine\Server;
use pocketmine\event\Event;
use pocketmine\event\EventPriority as Priority;
use pocketmine\event\Listener;

use prm\utils\Config;
use prm\Load;

class Players{
	public $path=false;
	public $players=array();
	public function __construct(){
		$this->path=Load::get()->path."players/";
		$this->config=new Config($this->path."../players-config.yml", array(
			"id"=>0,
		));
		$this->server=Server::getInstance();
		foreach(array("Login", "Quit") as $e)
			$this->server->getPluginManager()->registerEvent("pocketmine\\event\\player\\Player".$e."Event", $this, EventPriority::HIGH, new CbEvtExe(array($this, "on".$e)), Load::get(), true);
	}
	public function onLogin(Event $event){
		$p=$event->getPlayer();
		$this->players[$p->getName()]=new Config($this->path.strtolower($p->getName()).".yml", array(
			"register-time"=>time(),
			"id"=>$this->config["id"]++,
		));
	}
	public function onQuit(Event $event){
		$p=$event->getPlayer();
		$this->players[$p->getName()]->save();
		unset($this->players[$p->getName()]);
	}
}
