<?php

class PRMMain{
	public $items=array();
	public $players=array();
	public function __construct(){
		PrmMainPlugin::get()->phys=new PrmPhys();
		PrmMainPlugin::get()->bio=new PrmBio();
		PrmMainPlugin::get()->soc=new PrmSoc();
		ServerAPI::request()->addHandler("player.equipment.change", array($this, "changeItem"));
		ServerAPI::requeset()->addHandler("player.join", array($this, "onJoin"));
		define("PRM_FILE_DIR", FILE_PATH."plugins/PocketRealisticMulti/saved-data/");
		@mkdir(PRM_FILE_DIR);
		define("PRM_PLAYERS_DIR", PRM_FILE_DIR."players/");
		@mkdir(PRM_PLAYERS_DIR);
	}
	public function changeItem($data){
		$this->items[$data["player"]->iusername]=$data["item"];
	}
	public function onJoin(Player $data){
		$this->players[$data->iusername]=new Config(PRM_PLAYERS_DIR.$data->iusername.".yml", CONFIG_YAML, array("Main"=>array(),));
		if(!file_exists(PRM_PLAYERS_DIR.$data->iusername.".yml"))
			ServerAPI::request()->dhandle("prm.new.player", $data);
		else ServerAPI::request()->dhandle("prm.old.player", $data);
	}
	public function getCarriedItem(Player $player){
		return $this->items[$player->iusername];
	}
}
