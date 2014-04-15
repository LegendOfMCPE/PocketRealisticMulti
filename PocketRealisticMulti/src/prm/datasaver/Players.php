<?php

namespace prm\datasaver;

use pemapmodder\utils\CallbackEventExe as CbEvtExe;

use pocketmine\Server;
use pocketmine\event\Event;
use pocketmine\event\EventPriority as Priority;
use pocketmine\event\Listener;

use prm\Load;

class Players{
	public function __construct(){
		foreach(array("Login", "Quit") as $e)
			Server::getInstance()->getPluginManager()->registerEvent("pocketmine\\event\\player\\Player".$e."Event", $this, EventPriority::HIGH, new CbEvtExe(array($this, "on".$e)), Load::get(), true);
	}
	public function onLogin(Event $event){
		$p=$event->getPlayer();
	}
	public function onQuit(Event $event){
		$p=$event->getPlayer();
	}
}
