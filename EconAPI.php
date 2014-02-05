<?php

class EconAPI{
	public $server, $config;
	public $list=array();
	public function init(){
		$this->server=ServerAPI::request();
		$s=$this->server;
		$s->addHandler("player.join", array($this, "evt"));
		$c=$s->api->console;
		$c->register("craft", "<name> [amount] Hold an item and run this command to craft", array($this,"craftCmd"));
		$dir=$s->api->plugin->configPath(PocketRealisticMultiPlugin::get());
		$ext=(file_exists($dir."Economy settings.txt") ? "txt" : "yml");
		$this->config=new Config($dir."Economy settings.$ext", CONFIG_YAML, array(
			"crafting recipes"=>array(
				"purse"=>array(
					array(PAPER=>3),
					array(LEATHER=>2)
				),
				"wallet"=>array(array(BOOK=>3))
			)
		));
	}
	public function evt($d,$inEvt){
		switch($inEvt){
			case "player.join":
				$this->list[$d->username]=new EconConfig();
				break;
			case "player.craft"://wt am i doing
				
				break;
		}
	}
	public function craftCmd($c,$a,$i){
		switch(strtolower($a[0])){
			case "purse":
				//$item=PocketRealisticMultiPlugin::get()->getCarriedItem($i);
				$recipes=$this->config->get("crafting recipes")["purse"];
				foreach($recipes as $recipe){
					foreach($recipe as $item){
						
					}
				}
				else return "";
		}
	}
	public function countInventory(Player $player, $needle){
		$haystack=$player->inventory;
		$result=0;
		foreach($haystack as $item){
			if($item->getID() === $needle)
				$result+=$item->count;
		}
		return $result;
	}
}
/*
class MoneyContainer{
	private $unit, $maxMoney;
	public function __construct($id, $meta, $count, $name, $unit){
		parent::__construct($id, $meta, $count, $name);
		$this->maxStackSize=1;
	}
}
*/
define("WALLET", 329);
/*class WalletItem extends MoneyContainer{
	public function __construct($meta=0, $count=1){
		parent::__construct(WALLET, $meta, $count, "Wallet", 100);
	}
}
*/
define("PURSE", 341);
/*
class PurseItem extends MoneyContainer{
	public function __construct($meta=0, $count=1){
		parent::__construct(PURSE, $meta, $count, "Purse", 10);
	}
}
*/
class EconConfig extends Config{
	public function __construct(Player $player){
		$path=ServerAPI::request()->api->plugin->configPath(PocketRealisticMulti::get())."econ/";
		@mkdir($path);
		$path.=$player->username[0]."/";
		@mkdir($path);
		$path.=$player->username.".yml";
		parent::__construct($path, CONFIG_YAML, array(self::getDefaultValues()));
		
	}
	private static function getDefaultValues(){
		return array(
			
		);
	}
}
