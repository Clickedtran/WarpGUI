<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\event;

use pocketmine\event\plugin\PluginEvent;
use ClickedTran\WarpGUI\manager\WarpManager;

class WarpEvent extends PluginEvent {
    
    /** @var WarpManager $plugin */
	public WarpManager $plugin;

	public function __construct(WarpManager $plugin){
		$this->plugin = $plugin;
	}
}