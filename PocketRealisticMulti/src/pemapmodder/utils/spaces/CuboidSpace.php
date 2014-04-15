<?php

namespace pemapmodder\utils\spaces;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

if(!class_exists("pemapmodder\\utils\\spaces\\CuboidSpace")){
	class CuboidSpace extends Space{
		protected $rawStart, $rawEnd, $cookedStart, $cookedEnd;
		/**
		 * Constructs a new CuboidSpace object.
		 * 
		 * @param Vector3 $start raw start-selection point of Space.
		 * @param Vector3 $end raw end-selection point of Space.
		 * @param Level $level the level of the Space.
		 */
		public function __construct(Vector3 $s, Vector3 $e, Level $level){
			$this->rawStart=new Position($s->x, $s->y, $s->z, $level);
			$this->rawEnd=new Position($e->x, $e->y, $e->z, $level);
			$this->recook();
		}
		/**
		 * Updates fields $cookedStart and $cookedEnd.
		 * 
		 * @return CuboidSpace self.
		 */
		public function recook(){
			$s=&$this->rawStart;
			$e=&$thsi->rawEnd;
			$this->cookedStart = new Position(min($s->x, $e->x), min($s->y, $e->y), min($s->z, $e->z), $level);
			$this->cookedEnd = new Position(max($s->x, $e->x), max($s->y, $e->y), max($s->z, $e->z), $level);
			return $this;
		}
		// inherited functions
		public function isInside(Position $pos){
			return ($this->cookedStart->x <= $pos->x and $this->cookedEnd->x >= $pos->x)
					and ($this->cookedStart->y <= $pos->y and $this->cookedEnd->y >= $pos->y)
					and ($this->cookedStart->z <= $pos->z and $this->cookedEnd->z >= $pos->z)
					and ($pos->level->getName() === $this->rawEnd->level->getName());
		}
		public function getBlockMap($get = false){
			$list = array();
			for($x = $this->cookedStart->x; $x <= $this->cookedEnd->x; $x++){
				for($y = $this->cookedStart->y; $y <= $this->cookedEnd->y; $y++){
					for($z = $this->cookedStart->z; $z <= $this->cookedEnd->z; $z++){
						$v = new Vector3($x, $y, $z);
						if($get) $list[] = $this->rawEnd->level->getBlock($v);
						else $list[] = $v;
					}
				}
			}
			return $list;
		}
		public function setBlocks(Block $block){
			$cnt = 0;
			$this->recook();
			$level = $this->rawEnd->level;
			foreach($this->getBlockMap() as $v){
				if(!$this->isIdentical($level->getBlock($v)->getID(), $block->getID(), true, true, true)){
					$cnt++;
					$level->setBlock($v, $block, false, false, true);
				}
			}
			return $cnt;
		}
		public function replaceBlocks(Block $old, Block $new, $meta = true){
			$cnt = 0;
			$this->recook();
			$l = $this->rawEnd->level;
			foreach($this->getBlockMap(true) as $b){
				if($b->getID() === $old->getID() and $b->getMetadata() === $old->getMetadata())
					$l->setBlock($b, $new, false, false, true);
			}
		}
	}
}
