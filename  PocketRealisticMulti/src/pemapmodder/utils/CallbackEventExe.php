<?php

namespace pemapmodder\utils;

use pocketmine\event\EventExecutor;

if(!class_exists("pemapmodder\\utils\\CallbackEventExe")){
	class CallbackEventExe implements EventExecutor{
		public function __construct(callable $callback){
			$this->cb = $cb;
		}
		public function execute(Listener $l, Event $evt){
			call_user_func($this->cb, $evt);
		}
	}
}
