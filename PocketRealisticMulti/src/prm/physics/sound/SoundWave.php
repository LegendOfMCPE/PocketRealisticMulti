<?php

namespace prm\physics\sound;

use pocketmine\level\Position;
use prm\Main;
use prm\physics\BlockResistanceData;
use prm\physics\tree\ActionTree;
use prm\physics\tree\Branch;

class SoundWave extends ActionTree{
	public function __construct(Position $position, $message, $magnitude, BlockResistanceData $data, Main $main){
		parent::__construct($position, $main, $magnitude, 0); // run it off instantly
	}
	public function onFinished(){
		foreach($this->getMain()->getServer()->getOnlinePlayers() as $player){
			if(($magnitude = $this->getMap()->findMagnitude($player)) > 3){

			}
		}
	}
	public function onBranchGrowth(Branch $branch){

	}
}
