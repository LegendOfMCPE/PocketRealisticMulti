<?php

/*
class=PocketRealMultiPlugin
name=PocketRealisticMulti
version=alpha 0.0.0
apiversion=11,12
author=PEMapModder
description=Sometimes when we ask for ranks too often, we would find that SCARCITY is the basis of the fun in MCPE survival, SMP or SSP. Do you think admins are needed? No, NOT AT ALL. We just need a console to ban hackers (real hackers who endanger the network safety, not the ones who cheat). And spammers in real life can just be left alone or be put a gag in their mouth. People don't need ladders to climb a mountain. A rope is enough for it.
*/
define("PRM_VOL_NORM", 5);
define("PRM_VOL_WHISPER", 2);
define("PRM_VOL_SHOUT", 8);
define("PRM_VOL_YELL", 10);
define("PRM_VOL_MAX", 12);
define("PRM_OKSTATUS_CANCELLED", 0x80);
define("PRM_OKSTATUS_PULL", 0x81);

class PocketRealMultiPlugin implements Plugin{
	public static $inst;
	private $noProfile=array();
	public static function get(){
		return (isset(self::$inst)?(self::$inst):false);
	}
	public $heldItems=array();
	public $api, $config;
	public $playersOkStatus=array();
	public $proposedSpawn, $defaultSpawn;
	public function __construct(ServerAPI $a,$s=0){
		ServerAPI::request()->loadAPI("prm", "PRMAPI", FILE_PATH."plugins/");
		ServerAPI::request()->loadAPI("econ", "EconAPI", FILE_PATH."plugins/");
		self::$inst=$this;
		$this->api=$a;
	}
	public function __destruct(){
		
	}
	public function init(){
		$s=ServerAPI::request();
		$a=$s->api;
		if("events"==="events"){
			$s->addHandler("player.chat", array($this, "event"));
			$s->addHandler("player.interact", array($this, "event"));
			$s->addHandler("player.equipment.change", array($this,"event"));
			$s->addHandler("console.command", array($this, "event"), 30);
			$s->addHandler("player.spawn", array($this, "event"));
			$s->addHandler("player.connect", array($this, "event"));
		}
		if("configs"==="configs"){
			$new=!file_exists($this->api->plugin->configPath($this)."settings.yml") and !file_exists($this->api->plugin->configPath($this)."settings.txt");
			if(!$new and file_exists($this->api->plugin->configPath($this)."settings.txt"))
				$path=$this->api->plugin->configPath($this)."settings.txt";
			else
			$path=$this->api->plugin->configPath($this)."settings.yml");
			$this->config=new Config($path, CONFIG_YAML, array(
				"default spawnpoint of newly-registered players"=>
					array("x"=>128, "y"=>80, "z"=>128, "level name"=>"world"),
				"require console to approve the setting of default spawnpoint"=>true
			));
			$this->nonUserConfig=new Config($this->api->plugin->configPath($this).
					"DO_NOT_EDIT_ME_UNLESS_YOU_KNOW_EXACTLY_WELL_WHAT_YOU_ARE_DOING.DONTEDIT", CONFIG_YAML, array(
						"WARNING"=>"Editing this file is dangerous. Some values seem to be what they mean literally while they aren't. For example, the noSuffo value does not simply mean no suffocation damage.",
						"noSuffo"=>true
					));
			if($new){
				console("[WARNING] [PRM] PocketRealisticMulti is newly loaded!\n".
						FORMAT_GREEN."New players may die for falling or suffocation if the config is not correctly set!\n".
						FORMAT_AQUA."Please join the game with MCPE and set your gamemode to creative.\n".
						FORMAT_YELLOW."Then at a point suitable for default spawnpoint, run the command /dftspawn.\n".
						FORMAT_GREEN."Then approve it by running the command /dftspawn on console.\n".
						FORMAT_AQUA."If you want to allow setting of default spawnpoint without console approval, change it in the settings file at $path.\n".
						FORMAT_YELLOW."Before it is set by command or changed in the config file, players will ".FORMAT_BOLD.FORMAT_UNDERLINE.FORMAT_LIGHT_PURPLE."NOT".FORMAT_RESET.FORMAT_YELLOW." die of suffocation or fall damage.");
			}
			if($this->config->get("default spawnpoint of newly-registered players")!=array("x"=>128, "y"=>80, "z"=>128, "level name"=>"world")){
				$this->nonUserConfig->set("noSuffo", false);
				$this->nonUserConfig->save();
			}
		}
		if("cmds"==="cmds"){
			$this->api->console->register("dftspawn", "", array($this, "dftSpawn"));
		}
	}
	public function getDftSpawn(){
		return $this->defaultSpawn;
	}
	public function dftSpawn($c,$a,$player){
		if($player==="rcon")
			return "Please run this command in-game. ";
		if($player instanceof Player){
			if($this->config->get("require console to approve the setting of default spawnpoint")!==false){
				$player->sendChat("If you are not the owner, you don't have the power to set default spawnpoint.\n".
						"If you are the owner, please approve this setting of default spawn by running the command /dftspawn on console.");
				$this->proposedSpawn=array($player->username, $player->entity);
			}
			else{
				$pos=$player->entity;
				$this->config->set("default spawnpoint of newly-registered players", array("x"=>$pos->x, "y"=>$pos->y, "z"=>$pos->z, "level"=>$pos->level));
				$this->config->save();
				$this->defaultSpawn=$pos;
			}
		}
		if($player==="console"){
			if(isset($this->proposedSpawn) and $this->proposedSpawn!==false){
				$this->defaultSpawn=$this->proposedSpawn;
				$pos=$this->defaultSpawn;
				$this->config->set("default spawnpoint of newly-registered players", array("x"=>$pos->x, "y"=>$pos->y, "z"=>$pos->z, "level"=>$pos->level));
				$this->config->save();
				$this->proposedSpawn=false;
				return "Default spawnpoint set to ".$this->defaultSpawn;//__toString
			}
			else return "Please run this command in-game ".FORMAT_BOLD."first".FORMAT_RESET.". Or did you already approved?";
		}
	}
	public function event($d,$inEvt){
		switch($inEvt){
			case "player.chat":
				$msg=$d["message"];
				$this->api->prm->announceAt($d["player"]->entity, $msg, PRM_VOL_NORM, $d["player"]);
				return false;
			case "player.interact":
				$item=$this->heldItems[$d["player"]->username];
				if($item->getID()===287 and $item->count >= ((int)($d["player"]->entity->distance($d["target"])))){
					$player=$this->api->player->getByEID($d["target"]->getEID());
					if($player instanceof Player){
						$player->sendChat($d["player"]->username." wants to pull you to him with a string.\nAgree? Use /ok to accept pulling.");
						$this->playerOkStatus[$player->username]=array(PRM_OKSTATUS_PULL, $d["player"]);
					}
					else{
						$d["target"]->setPosition($d["player"]->entity);
						$d["player"]->sendChat("Successfully pulled a non-player entity to you.");
					}
				}elseif($item->getID()===287){
					$target=$this->api->prm->getEntityName($d["target"]);
					$d["player"]->sendChat("You failed to pull $target because the string you are using is too short. A minimum of ".((int)($d["player"]->entity->distance($d["target"])))." of string is needed.");
				}
				//what I meant for this is, when they want to send a player to jail, they just kill the player and the player will respawn at spawn (while the jail must be at spawn) and if newly spawned players are in jail people can use strings to pull them out of jail.
				break;
			case "player.equipment.change":
				$this->heldItems[$d["player"]->username]=$d["item"];
				break;
			case "console.command":
				if($d["cmd"]==="ok" and ($d["issuer"] instanceof Player)){
					if(!isset($this->playersOkStatus[$d["issuer"]->username]) or ($data=$this->playersOkStatus[$d["issuer"]->username])[0]===PRM_OKSTATUS_CANCELLED)
						$this->api->handle("player.chat", array("player"=>$d["issuer"], "message"=>"ok"));
					switch($data[0]){
						case PRM_OKSTATUS_PULL:
							$d["issuer"]->teleport($data[1]->entity);
							$d["issuer"]->sendChat("You have been pulled to ".$data[1]." via string.");
							$this->playersOkStatus[$d["issuer"]->username][0]=PRM_OKSTATUS_CANCELLED;
							break;
					}
				}
				if($d["cmd"]==="spawn"){ // overriding /spawn is too risky
					$d["player"]->sendChat("[PEMapModder->me] The security guards in the hospital would refuse to let me go to the place where I was born. So now I would refuse to let you teleport to the place where you were spawned. Yet you should thank me; I wouldn't refuse to let you walk to spawn.");
					return "prevent";
				}
				return true;
			case "player.spawn":
				$ign=strtolower($d->username);
				if(isset($this->noProfile[$ign]) and $this->noProfile[$ign]===true){
					$this->server->schedule(40, array($this, "tpToWild"), $d);
					$this->noProfile[$ign]=false;
				}
				break;
			case "player.connect":
				$ign=strtolower($d->username);
				if(!file_exists(FILE_PATH."players/$ign.yml"))
					$this->noProfile[$ign]=true;
				break;
		}
		
	}
	public function tpToWild($player, $evt){
		$c=PocketRealisticMultiPlugin::get()->config;
		$player->teleport();
	}
	public function getCarriedItem($player){
		return (isset($this->heldItems["$player"]) ? $this->heldItems["$player"] : false);
	}
}
