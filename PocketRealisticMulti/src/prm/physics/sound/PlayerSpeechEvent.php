<?php

namespace prm\physics\sound;

use pocketmine\event\Cancellable;
use pocketmine\event\player\PlayerEvent;
use pocketmine\Player;

class PlayerSpeechEvent extends PlayerEvent implements Cancellable{
	public static $handlerList = null;
	protected $message;
	protected $volume;
	public function __construct(Player $player, $message, $volume){
		$this->player = $player;
		$this->message = $message;
		$this->volume = $volume;
	}
	public function getMessage(){
		return $this->message;
	}
	/**
	 * @param mixed $message
	 */
	public function setMessage($message){
		$this->message = $message;
	}
	/**
	 * @return mixed
	 */
	public function getVolume(){
		return $this->volume;
	}
	/**
	 * @param mixed $volume
	 */
	public function setVolume($volume){
		$this->volume = $volume;
	}
}
