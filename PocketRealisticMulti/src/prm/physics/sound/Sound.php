<?php

namespace prm\physics\sound;

use legendofmcpe\statscore\CustomPluginCommand;
use legendofmcpe\statscore\Table;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\level\Position;
use pocketmine\Player;
use prm\Main;
use prm\Submodule;

class Sound implements Submodule{
	private $enabled = false;
	private $server;
	private $main;
	private $config;
	/** @var Table */
	private $resistance;
	public function __construct(Main $main){
		$this->main = $main;
		$this->server = $this->main->getServer();
		$this->server->getPluginManager()->registerEvents($this, $main);
		$cmd = new CustomPluginCommand("speak", $this->main, array($this, "speakCmd"));
		$cmd->setAliases(["s"]);
		$cmd->reg("sound");
	}
	public function enable(array $set){
		if($this->enabled === true){
			return;
		}
		$this->config = $set;
		$this->resistance = new Table($this->main->getDataFolder()."block properties.txt");
		$this->enabled = true;
	}
	public function disable(){
		if($this->enabled === false){
			return;
		}
		$this->enabled = false;
	}
	public function onChat(PlayerChatEvent $event){
		if($this->enabled === false or $this->config["chat override"] === false){
			return;
		}
		$message = sprintf($event->getFormat(), $event->getPlayer()->getDisplayName(), $event->getMessage());
		$this->playerSpeech($event->getPlayer(), $message, $this->config["chat default volume"]);
	}
	public function playerSpeech(Player $player, $message, $volume){
		$this->server->getPluginManager()->callEvent($ev = new PlayerSpeechEvent($player, $message, $volume));
		if(!$ev->isCancelled()){
			return false;
		}
		$this->sound($player, $message, $volume);
		return true;
	}
	public function sound(Position $position, $message, $volume){
		$wave = new SoundWave($position, $message, $volume, $this->getSoundResistanceData(), $this->main);
		$wave->init();
	}
	public function getSoundResistanceData(){
		return $this->main->getBlockProperties()->getKeyedColumn(0, 1);
	}
}
