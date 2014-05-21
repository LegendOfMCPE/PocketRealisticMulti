<?php

namespace prm\utils;

use pocketmine\plugin\EventExecutor;

class CbEvtExe implements EventExecutor{
	public function __construct($callback){
		$this->callback = $callback;
	}
	public function execute(Listener $listener, Event $event){
		$cb = $this->callback;
		$listener->$cb($event);
	}
}
