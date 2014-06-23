<?php

namespace prm\physics\tree;

use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;
use prm\Main;

abstract class ActionTree extends PluginTask{
	protected $magnitude;
	/** @var Branch[] $branches */
	protected $branches;
	protected $freq;
	/** @var MagnitudeMap */
	protected $map;
	protected $origin;
	/**
	 * @param Position $origin
	 * @param Main $plugin
	 * @param int $magnitude number of blocks to run
	 * @param int $freq frequency in ticks to run
	 */
	public function __construct(Position $origin, Main $plugin, $magnitude, $freq = 1){
		parent::__construct($plugin);
		$this->origin = $origin;
		$this->magnitude = $magnitude;
		$this->freq = $freq;
	}
	/**
	 * @return \pocketmine\level\Level
	 */
	public function getLevel(){
		return $this->origin->getLevel();
	}
	public function init(){
		$this->map = new MagnitudeMap($this);
		$this->branches = [new Branch($this->origin, $this->magnitude, $this)];
		if($this->freq > 0){
			$this->grow();
			$this->getOwner()->getServer()->getScheduler()->scheduleDelayedTask($this, $this->freq);
		}
		else{
			while($this->magnitude > 0){
				$this->grow();
			}
			$this->onFinished();
		}
	}
	public function onRun($t){
		$this->grow();
	}
	protected function grow(){
		$newBranches = [];
		foreach($this->branches as $branch){
			$branches = $branch->grow();
			foreach($branches as $b){
				if($this->map->pulse($b) !== false){
					$newBranches[] = $b;
				}
			}
		}
		if($this->magnitude > 0){
			$this->getOwner()->getServer()->getScheduler()->scheduleDelayedTask($this, $this->freq);
		}
		else{
			$this->onFinished();
		}
	}
	/**
	 * @return MagnitudeMap
	 */
	public function getMap(){
		return $this->map;
	}
	public function getMain(){
		return $this->owner;
	}
	public abstract function onBranchGrowth(Branch $branch); // wait for the subclass to handle things like resistance
	protected abstract function onFinished();
}
