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

class PocketRealMultiPlugin implements Plugin{
	public static $inst;
	public static function get(){
		return (isset(self::$inst)?(self::$inst):false);
	}
	
	private $api;
	public function __construct(ServerAPI $a,$s=0){
		ServerAPI::request()->loadAPI("prm", "PRMAPI", FILE_PATH."plugins/");
		self::$inst=$this;
		$this->api=$a;
	}
	public function __destruct(){}
	public function init(){
		$s=ServerAPI::request();
		$a=$s->api;
		$s->addHandler("player.chat", array($this,"evRed"));
	}
	public function evRed($d,$inEvt){
		switch($inEvt){
			case "player.chat":
				$msg=$d["message"];
				$this->api->prm->announceAt($d["player"]->entity, $msg, PRM_VOL_NORM, $d["player"]);
				return false;
		}
	}
}
