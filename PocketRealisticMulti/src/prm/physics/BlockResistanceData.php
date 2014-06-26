<?php

namespace prm\physics;

use pocketmine\block\Block;

class BlockResistanceData{
	private $data;
	public function __construct(array $data){
		$this->data;
	}
	public function getResistance(Block $block){
		$key = $block->getID().":".$block->getDamage();
		if(isset($this->data[$key]) and is_numeric($this->data[$key])){
			return $this->data[$key];
		}
		$key = $block->getID().""; // cast to string
		if(isset($this->data[$key]) and is_numeric($this->data[$key])){
			return $this->data[$key];
		}
		return $this->data["default"];
	}
}
