<?php

class PRMMain{
	$items=array();
	public function __construct(){
		PrmMainPlugin::get()->phys=new PrmPhys();
		PrmMainPlugin::get()->bio=new PrmBio();
		PrmMainPlugin::get()->soc=new PrmSoc();
		ServerAPI::request()->addHandler("player.equipment.change", array($this, "changeItem"));
	}
	public function changeItem($data){
		$this->items[$data["player"]->iusername]=$data["item"];
	}
	public function getCarriedItem(Player $player){
		return $this->items[$player->iusername];
	}
}
