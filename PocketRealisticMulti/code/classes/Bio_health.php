<?php

class PrmHealthHandler{
	public $healths=array();
	public function __construct(){
		ServerAPI::request()->addHandler("player.spawn", array($this, "add"));
		ServerAPI::request()->addHandler("player.quit", array($this, "rm"));
		ServerAPI::request()->addHandler("player.respawn", array($this, "add"));
		// ServerAPI::request()->addHandler("player.death", array($this, "rm"));
	}
	public function add(Player $player){
		$this->healths[$player->iusername]=new Health($player);
	}
	public function rm(Player $player){
		unset($this->healths[$player->iusername]);
	}
}
class PrmHealth{
}
