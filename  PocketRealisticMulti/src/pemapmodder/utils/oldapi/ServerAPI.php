<?php

namespace pemapmdoder\utils\oldapi;

use pemapmodder\utils\CallbackCmdExe;
use pemapmodder\utils\CallbackEventExe;
use pemapmodder\utils\CallbackPluginTask;

use pocketmine\Server;
use pocketmine\command\PluginCommand as Cmd;
use pocketmine\event\EventPriority;
use pocketmine\plugin\Plugin;

if(!class_exists("pemapmodder\\utils\\oldapi\\ServerAPI")){
	class ServerAPI{
		public function addHandler($event, callable $callback, Plugin $plugin = null){
			Server::getInstance()->getPluginManager()->registerEvent(Dep::$names[$event], null, EventPriority::NORMAL, new CallbackEventExe($callback), $plugin === null ? $callback[0]:$plugin);
		}
		public function schedule($ticks, callable $callback, $data, $repeat, Plugin $plugin = null){
			$task = new CallbackPluginTask($callback, $plugin === null ? $callback[0]:$plugin, $data);
			if($repeat){
				Server::getInstance()->getScheduler()->scheduleRepeatedTask($task, $ticks);
			}
			else{
				Server::getInstance()->getScheduler()->scheduleDelayedTask($task, $ticks);
			}
		}
		public function console_register($cmd, $desc, callable $callback, array $aliases = array()){
			$cmd = new Cmd($cmd, new CallbackCmdExe($callback));
			$cmd->setDescription($desc);
			$cmd->setAliases($aliases);
			$cmd->register(Server::getInstance()->getCommandMap());
		}
	}
}
if(!class_exists("pemapmodder\\utils\\oldapi\\Dep")){
	class Dep{ // deprecations
		public static $names = array(
			"player.connect" => "pocketmine\\event\\player\\PlayerPreLoginEvent",
			"player.join" => "pocketmine\\event\\player\\PlayerLoginEvent",
			"player.spawn" => "pocketmine\\event\\player\\PlayerJoinEvent",
			"player.respawn" => "pocketmine\\event\\player\\PlayerRespawnEvent",
			"player.quit" => "pocketmine\\event\\player\\PlayerQuitEvent",
			"player.kick" => "pocketmine\\event\\player\\PlayerKickEvent",
			"player.block.touch" => "pocketmine\\event\\player\\PlayerInteractEvent",
			"player.block.place" => "pocketmine\\event\\block\\BlockPlaceEvent",
			"player.block.break" => "pocketmine\\event\\block\\BlockBreakEvent",
			"player.equipment.change" => "pocketmine\\event\\player\\PlayerItemHeldEvent",
			"player.gamemode.change" => "pocketmine\\event\\player\\PlayerGameModeChangeEvent",
			"player.chat" => "pocketmine\\event\\player\\PlayerChatEvent",
			"player.container.slot" => "pocketmine\\event\\inventory\\EntityInventoryChangeEvent",
			"player.armor" => "pocketmine\\event\\entity\\EntityArmorChangedEvent",
			"player.teleport.level" => "pocketmine\\entity\\EntityLevelChangeEvent",
			"console.command" => "pocketmine\\event\\player\\PlayerCommandPreprocessEvent", // as well as pocktmine\event\server\ServerCommandEvent
			"entity.add" => "pocketmine\\event\\entity\\EntitySpawnEvent",
			"entity.remove" => "pocketmine\\event\\entity\\EntityDespawnEvent",
			"entity.explosion" => "pocketmine\\event\\entity\\EntityExplodeEvent",
			"entity.move" => "pocketmine\\event\\entity\\EntityMoveEvent",
			"entity.motion" => "pocketmine\\event\\entity\\EntityMotionEvent",
			"tile.container.slot" => "pocketmine\\event\\TileInventoryChangeEvent",
		);
	}
}
