<?php

function prm_load_list($class){
	switch($class){
	case "PrmPhys":
		return array("PrmGravityHandler", "PrmSoundHandler");
	case "PrmBio":
		return array("PrmHealthHandler");
	case "PrmSoc":
		return array("PrmEcon", "PrmPhilo");
	}
}
