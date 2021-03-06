<?php

/*

           -
         /   \
      /         \
   /   PocketMine  \
/          MP         \
|\     @shoghicp     /|
|.   \           /   .|
| ..     \   /     .. |
|    ..    |    ..    |
|       .. | ..       |
\          |          /
   \       |       /
      \    |    /
         \ | /

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.


*/

class CakeBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(CAKE_BLOCK, 0, "Cake Block");
		$this->isFullBlock = false;
		$this->isActivable = true;
		$this->meta = $meta & 0x07;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){ //Replace wit common break method
				$this->level->setBlock($this, new AirBlock(), false);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		return array();
	}
	
	public function onActivate(Item $item, Player $player){
		if($player->entity->getHealth() < 20){
			++$this->meta;
			$player->entity->heal(3, "cake");
			if($this->meta >= 0x06){
				$this->level->setBlock($this, new AirBlock());
			}else{
				$this->level->setBlock($this, $this);
			}
			return true;
		}
		return false;
	}
	
}