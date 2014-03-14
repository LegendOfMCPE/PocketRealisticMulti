<<<<<<< HEAD:Society/EconAPI.php
<?php

/*
__PocketMine Plugin__
class=none
name=EconAPI
version=alpha 0.0.0
apiversion=12
author=PEMapModder
*/

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
				"purse"=>array(PURSE, array(
					array(PAPER=>3),
					array(LEATHER=>2)
				)),
				"wallet"=>array(WALLET, array(
					array(BOOK=>3))
				)
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
		if((isset($a[1]) and is_int($a[1])) or (isset($a[2]) and is_int($a[2])))return "Usage: /craft <item> [amount (integer)] [recipe id (integer)]";
		$requiredAmount=isset($a[1])?$a[1]:1;
			//$item=PocketRealisticMultiPlugin::get()->getCarriedItem($i);
			$recipes=$this->config->get("crafting recipes")[$a[0]][1];
			$acceptedRecipes=array();
			if(isset($a[2])){
				$recipe=$recipes[$a[2]];
				foreach($recipe as $id=>$min){
					if($this->countInventory($i, $id)<$min*$requiredAmount)
						return "You don't have enough ".$this->getItemName($id)."s to craft a ".$a[0].".";
				}
				foreach($recipe as $id=>$amount){
					$i->removeItem($id, 0, $amount);
				}
				
			}
			foreach($recipes as $recipe){
				$status=true;
				foreach($recipe as $id=>$min){
					if($this->countInventory($i, $id)<$min*$requiredAmount){
						$status=false;
						break;
					}
				}
				if($status===true){
					$acceptedRecipes[]=$recipe;
				}
			}
			if(count
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
	public function getItemName($id){
		if(isset(Item::$class[$id]))
			$ret=Item::$class[$id];
		elseif(isset(Block::$class[$id]))
			$ret=Block::$class[$id];
		else return "Unknown ($id)";
		return str_replace("Item", "", $ret);
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
=======
<?php

class PrmSociety{
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
				"purse"=>array(PURSE, array(
					array(PAPER=>3),
					array(LEATHER=>2)
				)),
				"wallet"=>array(WALLET, array(
					array(BOOK=>3))
				)
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
		if((isset($a[1]) and is_int($a[1])) or (isset($a[2]) and is_int($a[2])))return "Usage: /craft <item> [amount (integer)] [recipe id (integer)]";
		$requiredAmount=isset($a[1])?$a[1]:1;
			//$item=PocketRealisticMultiPlugin::get()->getCarriedItem($i);
			$recipes=$this->config->get("crafting recipes")[$a[0]][1];
			$acceptedRecipes=array();
			if(isset($a[2])){
				$recipe=$recipes[$a[2]];
				foreach($recipe as $id=>$min){
					if($this->countInventory($i, $id)<$min*$requiredAmount)
						return "You don't have enough ".$this->getItemName($id)."s to craft a ".$a[0].".";
				}
				foreach($recipe as $id=>$amount){
					$i->removeItem($id, 0, $amount);
				}
				
			}
			foreach($recipes as $recipe){
				$status=true;
				foreach($recipe as $id=>$min){
					if($this->countInventory($i, $id)<$min*$requiredAmount){
						$status=false;
						break;
					}
				}
				if($status===true){
					$acceptedRecipes[]=$recipe;
				}
			}
			if(count
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
	public function getItemName($id){
		if(isset(Item::$class[$id]))
			$ret=Item::$class[$id];
		elseif(isset(Block::$class[$id]))
			$ret=Block::$class[$id];
		else return "Unknown ($id)";
		return str_replace("Item", "", $ret);
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
>>>>>>> 6fbada94774668fe40f5803b81655eefd6568731:_old/Society/PrmSociety.php
