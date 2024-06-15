<?php

namespace ClickedTran\WarpGUI\manager;

use pocketmine\utils\Config;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;
use pocketmine\item\Item;
use pocketmine\world\Position;

use ClickedTran\WarpGUI\WarpGUI;
use ClickedTran\WarpGUI\event\AddWarpEvent;
use ClickedTran\WarpGUI\event\RemoveWarpEvent;
use ClickedTran\WarpGUI\event\TeleportWarpEvent;

class WarpManager {
    use SingletonTrait;

	public WarpGUI $plugin;

    public $warp;
    public $editwarp = [];

    public function __construct(){
        $this->plugin = WarpGUI::getInstance();
        $this->warp = new Config($this->plugin->getDataFolder() . "warp.yml", Config::YAML);
    }

    public function getWarp() : Config{
        return $this->warp;
    }

	public function addWarp(string $name){
		$this->getWarp()->set($name, [
                "position" => "",
                "world" => "",
                "item" => "",
                "slot" => ""
		]);
		$this->getWarp()->save();
		(new AddWarpEvent($this, $name))->call();
	}
        
	public function removeWarp(string $name){
		$all = $this->getWarp()->getAll();
		unset($all[$name]);
		$this->getWarp()->setAll($all);
		$this->getWarp()->save();
		(new RemoveWarpEvent($this, $name))->call();
	}
        
	public function getPositionWarps(string $name){
		if($this->getWarp()->exists($name)){
            $position = $this->getWarp()->get($name)["position"];
		    return $position;
		}
	}
        
	public function getWorldWarps(string $name){
		if($this->getWarp()->exists($name)){
		    $world = $this->getWarp()->get($name)["world"];
		    $worlds = $this->plugin->getServer()->getWorldManager()->getWorldByName($world);
		    return $worlds;
		}
	}
        
	public function teleportToWarp(Player $player, string $name){
		if($this->getWarp()->exists($name)){
			if($player instanceof Player){
				$ex = explode(" ", $pos = $this->getPositionWarps($name));
				$world = $this->getWorldWarps($name);
				$x = (int)$ex[0];
				$y = (int)$ex[1];
				$z = (int)$ex[2];
				$player->teleport(new Position($x, $y, $z, $world));
				(new TeleportWarpEvent($this, $player, $name))->call();
			}
		}
	}

	public function itemToData(Item $item): string {
        $cloneItem = clone $item;
        $itemNBT = $cloneItem->nbtSerialize();
        return base64_encode(serialize($itemNBT));
    }

    public function dataToItem(string $item): Item{
        $itemNBT = unserialize(base64_decode($item));
        return Item::nbtDeserialize($itemNBT);
    }
}
