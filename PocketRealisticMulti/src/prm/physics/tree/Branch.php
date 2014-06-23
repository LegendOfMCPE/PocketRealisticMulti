<?php

namespace prm\physics\tree;

use pocketmine\level\Position;

class Branch{
	/** @var Position $pos */
	private $pos;
	/** @var int $magnitude current magnitude */
	private $magnitude;
	/** @var ActionTree $tree owner tree */
	private $tree;
	/**
	 * @param Position $pos
	 * @param int $magnitude
	 * @param ActionTree $tree
	 */
	public function __construct(Position $pos, $magnitude, ActionTree $tree){
		$this->pos = $pos;
		$this->magnitude = $magnitude;
		$this->tree = $tree;
	}
	/**
	 * @return Branch[]
	 */
	public function grow(){
		$out = [];
		for($i = 0; $i < 6; $i++){
			$side = $this->pos->getSide($i);
			$out[] = new Branch($side, $this->magnitude - 1, $this->tree);
		}
		return $out;
	}
	public function getPos(){
		return $this->pos;
	}
	public function getMagnitude(){
		return $this->magnitude;
	}
}
