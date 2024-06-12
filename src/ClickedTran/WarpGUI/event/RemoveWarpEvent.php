<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\event;

use ClickedTran\WarpGUI\event\WarpEvent;
use ClickedTran\WarpGUI\manager\WarpManager;

class RemoveWarpEvent extends WarpEvent {
    
    /** @var WarpManager $plugin */
	public WarpManager $plugin;

    public $warp;

	public function __construct(WarpManager $plugin, string $warp){
		$this->plugin = $plugin;
		$this->warp = $warp;
	}

	public function getWarp() : string {
		return $this->warp;
	}
}