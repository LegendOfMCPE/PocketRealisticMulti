<?php

namespace pemapmodder\utils;

use pocketmine\command\Command as Cmd;
use pocketmine\command\CommandExecutor as CmdExe;
use pocketmine\command\CommandSender as Isr;

class CallbackCmdExe implements CmdExe{
	public function __construct(callable $callback){
		$this->cb = $callback;
	}
	public function onCommand(Isr $isr, Cmd $cmd, $label, array $args){
		call_user_func($this->cb, $cmd->getName(), $args, $isr, $label);
	}
}
