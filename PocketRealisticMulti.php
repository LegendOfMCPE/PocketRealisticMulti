<?php

/*
__PocketMine Plugin__
class=PrmMainPlugin
name=PocketRealisticMulti
version=alpha 1.0
apiversion=12,13
author=PEMapModder
*/

class PrmMainPlugin{
	public $api, $server;
	private static $instance = false;
	private static function setInstance(self &$i){
		self::$instance =& $i;
	}
	public function __construct(ServerAPI $api, $s = 0){
		self::setInstance(&$this);
		$this->api = $api;
		$this->server = ServerAPI::request();
	}
	public function __destruct(){
	}
	public function init(){
		
	}
}
