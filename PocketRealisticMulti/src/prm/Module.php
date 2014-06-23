<?php

namespace prm;

use pocketmine\event\Listener;

interface Module extends Listener{
	public function __construct(Main $main);
	public function enable(array $data);
	public function disable();
}
