<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI;

use pocketmine\plugin\PluginBase;

use muqsit\invmenu\InvMenuHandler;
use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;

use ClickedTran\WarpGUI\commands\WarpGUICommands;
use ClickedTran\WarpGUI\manager\WarpManager;

class WarpGUI extends PluginBase {
        
	/** @var WarpGUI */
	public static $instance;

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable() : void {
		$this->saveResource("config.yml");
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->getServer()->getCommandMap()->register("WarpGUI", new WarpGUICommands($this, "warpgui", "§o§7Warp Commands", ["warp"]));
		self::$instance = $this;
		if(!InvMenuHandler::isRegistered()) InvMenuHandler::register($this);
        if(!PacketHooker::isRegistered()) PacketHooker::register($this);
	}

	public function onDisable() : void {
		WarpManager::getInstance()->saveAllWarp();
	}
}
