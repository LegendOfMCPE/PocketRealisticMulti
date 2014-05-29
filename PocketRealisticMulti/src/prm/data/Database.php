<?php

namespace prm\data;

use prm\Load;

class Database{
	public function __construct(Load $plugin, $name = "players", $api = null){
		$this->main = $plugin;
		$this->path = $plugin->getDataFolder()."$name/";
		$this->api = $api === null ? Load::CURRENT_API:$api;
		@mkdir($this->path = $this->main->getDataFolder()."players/");
	}
	public function get(Player $player){
		return @$this->sessions[$player->CID];
	}
	public function pInit(Player $player){
		$this->sessions[$player->CID] = new Session($player, $this->path.strtolower($player->getName()).".json");
	}
	
}
