<?php

class PrmPhiloBirth{
	public function __construct(){
		define("PRM_BIRTH_DIR", PRM_FILE_DIR."birth/");
		ServerAPI::request()->addHandler("prm.new.player", array($this, "onJoin"));
		ServerAPI::request()->addHandler("player.spawn", array($this, "onSpawn"));
		$this->dataConfig=new Config(PRM_BIRTH_DIR."main.yml", CONFIG_YAML, array("number-of-used-ids"=>0));
	}
	public function onJoin(Player $player){
		$id=$this->dataConfig->get("number-of-used-ids");
		$this->dataConfig->set("number-of-used-ids", $id+1);
		$this->dataConfig->save();
		$config=PrmMainPlugin::request()->players[$player->iusername];
		$config->set("birth"=>array(
				"birth-time"=>time(),
				"id"=>$id,
				"is-first-spawned"=>false,
		));
		$config->save();
	}
	public function onSpawn(Player $data){
		$list=ServerAPI::request()->api->player->getAll();
		if(count($list)===0){
			$list->sendChat("Welcome to ".ServerAPI::request()->api->getProperty("server-name")."! You are an orphan. No parents are taking you.");
			return;
		}
		$p=array_rand($list);
		$data->teleport($p->entity);
		$data->sendChat("Say hello to $p! He/She is your father/mother.");
		$p->sendChat("$data is your new child. Take care of him well and he should repay you, morally.");
	}
}
