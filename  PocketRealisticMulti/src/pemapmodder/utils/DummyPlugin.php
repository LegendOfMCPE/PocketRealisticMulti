<?php

namespace pemapmodder\utils;

use pocketmine\utils\PluginBase;

if(!class_exists("pemapmodder\\utils\\DummyPlugin")){
	class DummyPlugin extends PluginBase{
		public function onLoad(){
			console(pocketmine\utils\TextFormat::GREEN.get_class()." has been loaded!");
		}
	}
}
