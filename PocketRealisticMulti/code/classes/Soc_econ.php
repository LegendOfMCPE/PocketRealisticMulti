<?php

class PrmEcon{
	public $config=false;
	public function __construct(){
		
	}
}
define("PURSE", 341);
define("WALLET", 329);
Item::$class[PURSE]="PurseItem";
Item::$class[WALLET]="WalletItem";
ServerAPI::request()->addHandler("player.interact", array("MoneyContainer", "staticUse"));
class MoneyContainer extends Item{
	protected $unit;
	public function __construct($id, $name, $meta=0, $unit){
		parent::__construct(PURSE, $meta, 1, $name);
		$this->unit=$unit;
		$this->maxStackSize=1;
		$this->isActivable=true;
	}
	public function onActivate(Level $level, Player $player, Block $space, Block $target, $face){
		if(!in_array($target->getSide(0)->getID(), array(0, 8, 9, 10, 11))){
			if($space->getSide(0)->getID()===FIRE or $space->getID()===FIRE){
				$player->sendChat("Hey, burning money is illegal!");
				return true;
			}
			ServerAPI::request()->api->entity->drop($space->add(0.5, 0.5, 0.5));
			$player->sendChat("A wallet containing \$".$this->getMoney()." has been thrown.");
			return true;
		}
		if($face===0)
			$player->sendChat("Don't throw money onto the ceiling!");
		else $player->sendChat("Don't throw money into the wall!");
	}
	public static function staticUse($data){
		$ent=ServerAPI::request()->api->entity->get($data["eid"]);
		$from=$data["entity"]->player;
		if($ent->class===ENTITY_PLAYER ){
			$item=PrmMainPlugin::request()->getCarriedItem($from);
			if($item instanceof self)
				return $item->onEntityUse($ent, $from);
		}
	}
	public function onEntityUse(Entity $ent, Player $from){
		$ent->addItem($this->getID(), $this->getMetadata(), 1);
		$ent->sendChat("$from gave you a $this.");
		$from->sendChat("You have given a $this to ".$ent->player->username.".");
		$from->removeItem($this->getID(), $this->getMetadata(), 1);
		return false;
	}
	public function getMoney(){
		return $this->unit*$this->meta;
	}
	public final function getMaxMoney(){
		return $this->unit*15;
	}
	public final function getUnit(){
		return $this->unit;
	}
	public function __toString(){
		return "{$this->name} containing \${$this->getMoney()}.";
	}
}
class PurseItem extends MoneyContainer{
	public function __construct($meta=0, $cnt=1){
		parent::__construct(PURSE, "Purse", $meta, 10);
	}
}
class WalletItem extends MoneyContainer{
	public function __construct($meta=0, $cnt=1){
		parent::__construct(WALLET, "Wallet", $meta, 100);
	}
}
