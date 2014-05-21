<?php

namespace prm\data;

use pocketmine\Player;

class PlayerDatabase{
	public function __construct($path, Player $player, $api){
		$this->config = new Config($path, self::getDefault(), $api);
		$this->config["last-online"] = time();
	}
	public static function getDefault(){
		return array(
			"first-online" => time(),
			"last-online" => time(),
			"physics" => Physics::getDefaultConfig(),
			"biology" => Biology::getDefaultConfig(),
			"society" => Society::getDefaultConfig(),
			"uid" => Load::get()->saved["id"]++
		);
	}
}
