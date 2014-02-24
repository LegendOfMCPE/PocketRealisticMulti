<?php

/*
__PocketMine Plugin__
class=none
name=PRMAPI
author=PEMapModder
version=alpha 0.0.0
apiversion=12

class PRMAPI{
	public $server, $langEn;
	public function __destruct(){
		
	}
	public function init(){
		console(FORMAT_GREEN."[INFO] PRM API loaded");
		if(file_exists($this->api->plugin->configPath($this)."english.txt"))
			$ext="txt";
		else $ext="lang";
		$this->langEn=new LangConfig($this->server->api->plugin->configPath(PocketRealisticMultiPlugin::get()), $this->getDefaultLang());
	}
	public function announceAt(Position $pos, $msg, $volume, $player=false){
		$om=$msg;
		foreach($this->server->api->player->getAll() as $player){
			if($player->entity->level->getName() === $pos->level->getName()){
				$dist=$pos->distance($player->entity);
				$chance=($dist<=$volume ? 100 :
					($dist>$volume*3 ? 0:
					($vol*3-$dist)*10)); // TODO Improvement on this mechanics
				for($i=0;$i<strlen($msg);$i++){
					if($rand(0, 99) > $msg)
						$msg=substr($msg, 0, $i) . "?" . substr($msg, $i+1);
				}
				$trimmed=strlen(trim($msg, "?"));
				$orig=strlen(trim($om, "?"));
				if($trimmed > 2 or $trimmed*100/$orig > 5) { // if less than three characters or 5% of the original message is delivered, do not annoy the player
					if($player instanceof Player)
						$msg="$player: $msg";
					$player->sendChat($msg);
				}
			}
		}
	}
	public function getDefaultLang(){
		return array(
			"mob_zombie"=>"zombie",
			"mob_creeper"=>"creeper"
		);
	}
	public function word($id, $lang="En"){//unused
		$lang="lang".$lang;
		return $this->$lang->get($id);
	}
	//entity utils
	public function getEntityName(Entity $e){
		$target="entity";
		$testPlayer=$this->api->player->getByEID($e->getEID());
		if($testPlayer instanceof Player)
			$target="$testPlayer";
		else{
			switch($e->type){
				$target="the ";
				case MOB_ZOMBIE:$target.=$this->word("zombie");
				break;case MOB_CREEPER:$target.=$this->word("creeper");
				break;case MOB_SKELETON:$target.=$this->word("skeleton");
				break;case MOB_SPIDER:$target.=$this->word("spider");
				break;case MOB_PIGMAN:$target.=$this->word("pigzombie");
				break;case MOB_CHICKEN:$target.=$this->word("chicken");
				break;case MOB_COW:$target.=$this->word("cow");
				break;case MOB_PIG:$target.=$this->word("pig");
				break;case MOB_SHEEP:$target.=($this->word($this->getLangColor($e->data["Color"])).$this->word("sheep"));
			}
		}
		return $target;
	}
	public function getColorById($c){
		if($c==1)return "color_range";
		if($c==2)return "color_magenta";
		if($c==3)return "color_blue_light";
		if($c==4)return "color_yellow";
		if($c==5)return "color_lime";
		if($c==6)return "color_pink";
		if($c==7)return "color_gray";
		if($c==8)return "color_gray_light";
		if($c==9)return "color_cyan";
		if($c==10)return "color_purple";
		if($c==11)return "color_blue";
		if($c==12)return "color_brown";
		if($c==13)return "color_green";
		if($c==14)return "color_red";
		if($c==15)return "color_black";
		return "color_white";
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
class LangConfig{//because built-in seems buggy // read-only
	public $file;
	public $data;
	public function __construct($path, $defaultData=array(), $updateTicks=6000){
		$this->file=$path;
		$fileContent="";
		if(!file_exists($path)){
			foreach($defaultData as $id=>$phrase){
				if(strpos($id, "=")!==false){
					$id="\"$id\"";//'"$id"'
				}
				$fileContent.="$id=$phrase\n";
			}
			file_put_contents($this->file, $fileContent);
		}
		$this->data=$defaultData;
		else{
			if(is_file($path)){
				
			}
			else{
				console("[ERROR] $path is a directory. Please delete it.");
				ServerAPI::request()->api->console->run("stop");
			}
		}
		//newline at end of file
	}
	public function get($id){
		return $this->data["$id"];
	}
	public function __toString(){
		return "language file at ".$this->file;
	}
}
