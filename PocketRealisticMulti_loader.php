<?php

/*
__PocketMine Plugin__
class=PrmMainPlugin
name=PocketRealisticMulti
version=alpha 1.0
apiversion=12,13
author=PEMapModder
*/

class PrmMainPlugin implements Plugin{
	public $api, $server;
	public $main=false, $phys=false, $bio=false, $soc=false;
	public function __construct(ServerAPI $api, $s=0){
		self::setInstance($this);
		$this->api=$api;
		$this->server=ServerAPI::request();
		self::requireAll();
	}
	public function __destruct(){
	}
	public function init(){
		$this->main=new PRMMain();
	}
	public function requireAll(){
		$path=FILE_PATH."plugins/PocketRealisticMulti/code/classes/";
		$dir=dir($path);
		while(($file=$dir->read())!==false){#TODO
			if(is_file($path.$file) and substr($file, -4)==".php")
				require_once($path.$file);
		}
	}
	private static $instance=false;
	private static function setInstance(self &$i){
		self::$instance=&$i;
	}
	public static function get(){
		return self::$instance;
	}
	public static function request($c="main"){
		return self::get()->$c;
	}
}
