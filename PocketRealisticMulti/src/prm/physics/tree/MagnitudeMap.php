<?php

namespace prm\physics\tree;

use pocketmine\level\Position;

class MagnitudeMap{
	private $tree;
	/** @var int[] magnitudes, indexed by MagnitudeMap::keyPos(Position) */
	private $data = [];
	public function __construct(ActionTree $tree){
		$this->tree = $tree;
	}
	/**
	 * @param Branch $branch
	 * @return bool
	 */
	public function pulse(Branch $branch){
		if($this->tree->onBranchGrowth($branch) === false){
			return false;
		}
		$pos = $branch->getPos();
		$magnitude = $branch->getMagnitude();
		$key = $this->keyPos($pos);
		if(isset($this->data[$key]) and $this->data[$key] >= $magnitude){
			return false;
		}
		$this->data[$key] = $magnitude;
		return true;
	}
	/**
	 * @param Position $pos
	 * @param $difference
	 * @return bool
	 */
	public function diminish(Position $pos, $difference){
		$key = $this->keyPos($pos);
		if(!isset($this->data[$key])){
			return false;
		}
		if($this->data[$key] - $difference < 0){
			return false;
		}
		$this->data[$key] -= $difference; // avoid negative values
		return true;
		// WARNING: Do not call ActionTree functions to avoid infinite loop
	}
	/**
	 * @param Position $pos
	 * @return string
	 */
	private function keyPos(Position $pos){
		return $pos->getFloorX().",".$pos->getFloorY().",".$pos->getFloorZ();
	}
	public function getData(){
		return $this->data;
	}
	/**
	 * @param string $string
	 * @return Position
	 */
	public function unkeyPos($string){
		$pieces = explode(",", $string);
		return new Position((int) $pieces[0], (int) $pieces[1], (int) $pieces[2], $this->tree->getLevel());
	}
	public function findMagnitude(Position $pos){
		if($pos->getLevel()->getName() !== $this->tree->getLevel()->getName()){
			return 0;
		}
		$magnitude = 0;
		for($i = 0; $i < 6; $i++){
			if(isset($this->data[$key = $this->keyPos($pos->getSide($i))])){
				$magnitude = max($magnitude, $this->data[$key]);
			}
		}
		return $magnitude;
	}
}
