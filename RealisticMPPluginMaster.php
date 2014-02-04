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
	public static function get(){
		return (isset(self::$inst)?(self::$inst):false);
	}
	public $heldItems=array();
	private $api;
	private $playersOkStatus=array();
	public function __construct(ServerAPI $a,$s=0){
		ServerAPI::request()->loadAPI("prm", "PRMAPI", FILE_PATH."plugins/");
		self::$inst=$this;
		$this->api=$a;
	}
	public function __destruct(){}
	public function init(){
		$s=ServerAPI::request();
		$a=$s->api;
		$s->addHandler("player.chat", array($this,"evt"));
		$s->addHandler("player.interact", array($this,"evt"));
		$s->addHandler("player.equipment.change", array($this,"evt"));
	}
	public function evt($d,$inEvt){
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
				break;
			case "player.equipment.change":
				$this->heldItems[$d["player"]->username]=$d["item"];
			case "console.command":
				if($d["cmd"]==="ok" and ($d["issuer"] instanceof Player)){
					if(!isset($this->playersOkStatus[$d["issuer"]->username]) or ($data=$this->playersOkStatus[$d["issuer"]->username])[0]===PRM_OKSTATUS_CANCELLED)
						$this->api->handle("player.chat", array("player"=>$d["issuer"], "message"=>"ok"));
					switch($data[0]){
						case PRM_OKSTATUS_PULL:
							$d["issuer"]->teleport($data[1]->entity);
							$d["issuer"]->sendChat("You have been pulled to ".$data[1]." via string.");
							break;
					}
				}
		}
		
	}
	
}
