<?php

namespace prm\data;

use prm\Load;

class Database{
	public function __construct(Load $plugin, $name = "players", $api = null){
		$this->main = $plugin;
		$this->path = $plugin->getDataFolder()."$name/";
		$this->api = $api === null ? Load::CURRENT_API:$api;
	}
	public function getPlayer(Player $player){ // you can directly array-access the returned object without the necessity to return with reference
		return new PlayerDatabase($this->path.$player->getName().".json", $player, $this->api);
	}
}
