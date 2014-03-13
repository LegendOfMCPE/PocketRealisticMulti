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
		self::$instance=&$i;
	}
	public function __construct(ServerAPI $api, $s=0){
		self::setInstance(&$this);
		$this->api=$api;
		$this->server=ServerAPI::request();
		self::requireAll();
	}
	public function __destruct(){
	}
	public function init(){
		
	}
	public function requireAll(){
		$path=FILE_PATH."plugins/PocketRealisticMulti/code/classes/";
		$dir=dir($path);
		while(($file=$dir->read())!==false){#TODO
		}
	}
}
