<?php

class PRMAPI{
	private $server;
	public function __construct(){
		console(FORMAT_GREEN."[INFO] PRM API loaded");
	}
	public function __destruct(){
		
	}
	public function init(){
		
	}
	public function announceAt(Position $pos, $msg, $volume, $player=false){
		$om=$msg;
		foreach($this->server->api->player->getAll() as $player){
			if($player->entity->level->getName() === $pos->level->getName()){
				$dist=$pos->distance($player->entity);
				
				
				$chance=$volume*100/$dist; // TODO Improvement on this chance mechanic
				
				
				$chance=min($chance, 100);
				for($i=0;$i<strlen($msg);$i++){
					if($rand(0, 99) > $msg)
						$msg=substr($msg, 0, $i) . "?" . substr($msg, $i+1);
				}
				if(!(strlen(str_replace("?", "", $msg)) < 2 or strlen($om) / strlen(str_replace("?", "", $msg)) > 10)) { // if less than two characters or 10% of the original message is delivered, do not annoy the player
					if($player instanceof Player)
						$msg="$player: $msg";
					$player->sendChat($msg);
				}
			}
		}
	}
	//entity utils
	public function getEntityName(Entity $e){
		$target="entity";
		$testPlayer=$this->api->player->getByEID($e->getEID());
		if($testPlayer instanceof Player)
			$target="$testPlayer";
		else{
			switch($e->type){
				case MOB_ZOMBIE:$target="the zombie";
				break;case MOB_CREEPER:$target="the creeper";
				break;case MOB_SKELETON:$target="the skeleton";
				break;case MOB_SPIDER:$target="the spider";
				break;case MOB_PIGMAN:$target="the zombie pigman";
				break;case MOB_CHICKEN:$target="the chicken";
				break;case MOB_COW:$target="the cow";
				break;case MOB_PIG:$target="the pig";
				break;case MOB_SHEEP:
					$color=$this->getColorById($e->data["Color"]);
					$target="the ".$color." sheep";
			}
		}
		return $target;
	}
	public function getColorById($c){
		if($c==0)return "white";
		if($c==15)return "black";
		return "";
		// TODO more colours
	}
}
class PlayerRecord extends Config{
	private $dir, $file;
	private $player;
	public function __construct(Player $player, $filename="main"){
		$dir=FILE_PATH."plugins/PRM/";
		@mkdir($dir);
		$dir.="players/";
		@mkdir($dir);
		$dir.=substr($player->username, 0, 1)."/";
		@mkdir($dir);
		$dir.="$player/"
		@mkdir($dir);
		$this->dir=$dir;
		parent::__construct($dir."$filename.yml", CONFIG_YAML, array());
		ServerAPI::request()->schedule(1200*5, array($this, "scheduledSave"));
		$this->player=$player->username;
	}
	public function scheduledSave(){
		$this->save();
		if(ServerAPI::request()->api->player->get($this->player, false) instanceof Player)
			ServerAPI::request()->schedule(1200*5, array($this, "scheduledSave"));
	}
}
