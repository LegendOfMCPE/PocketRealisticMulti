<?php

class PrmSoundHandler{
	public function __construct(){
		ServerAPI::request()->addHandler("player.chat", array($this, "onChat"));
	}
	public function onChat($data){
		$sound=new PrmSoundWave($data["player"]->entity, PrmSoundWave::TYPE_MESSAGE, $data["message"]
	}
}
class PrmSoundWave{
	const TYPE_MESSAGE=0;
	public $ends, $type, $data, $mgnt;
	public function __construct(Position $origin, $type, $data, $magnitude=5){
		$this->origin=$origin;
		$this->ends=array($origin);
		$this->type=$type;
		$this->data=$data;
		$this->mgnt=$magnitude*10;
	}
	public function update(){
		$newEnds=array();
		foreach($this->ends as $end){
			for($i=0; $i<6; $i++){//someone checks this please
				$b=$end->getSide($i);
				$id=$b->level->getBlock($b)->getID();
				if($id===0 or $id===8 or $id===9){
					$newEnds[]=$b;
				}
			}
		}
		$this->ends=$newEnds;
		$this->send();
		$this->mgnt--;
		if($this->mgnt>0)
			ServerAPI::request()->schedule(1, array($this, "update"));
	}
	public function send(){
		foreach(ServerAPI::request()->api->player->getAll($this->origin->level) as $p){
			foreach($this->ends as $end){
				if($end->distance($p->entity) < 1){
					if($this->type===self::TYPE_MESSAGE){
						$sentence="";
						for($i=0; $i<strlen($this->data); $i++){
							if($this->mgnt>mt_rand(0, 100))
								$sentence.=substr($this->data, $i, 1);
							else $sntence.="?";
						}
						if(strlen(str_replace("?", "", $sentence)) > 
							$p->sendChat($sentence);
					}
				}
			}
		}
	}
	public function __toString(){
		return "Sound wave originating from {$this->origin} with magnitude {$this->mgnt}.";
	}
}
