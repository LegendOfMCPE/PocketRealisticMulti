<?php

namespace prm;

use pocketmine\Server;
use pocketmine\event\Listener;

abstract class Category implements Listener{
	protected $server, $plugin;
	function __construct(){
		$this->plugin = Load::get();
		$this->server = Server::getInstance();
		$this->server->getPluginManager()->registerEvents($this, $this->plugin);
	}
	public abstract function getDefaultPConfig();
}
