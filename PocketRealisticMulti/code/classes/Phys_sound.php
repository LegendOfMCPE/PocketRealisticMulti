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
	public function __construct(Position $origin, $type, $data, $magnitude=5){
	}
}
