<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\gui;

use Closure;
use pocketmine\player\Player;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use ClickedTran\WarpGUI\WarpGUI;
use ClickedTran\WarpGUI\manager\WarpManager;

class GUIManager {

	public function menuWarpGUI(Player $player){
		$all_warp = WarpManager::getInstance()->getWarp()->getAll();
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$menu->setName(WarpGUI::getInstance()->getConfig()->get("menu-name"));
		$menu->setListener(Closure::fromCallable([$this, "menuWarpGUIListener"]));
		$inv = $menu->getInventory();
		if(count($all_warp) >= 1){
	        foreach($all_warp as $warp => $slot){
	        	$item = WarpManager::getInstance()->dataToItem($all_warp[$warp]["item"]);
	        	$inv->setItem($all_warp[$warp]["slot"], 
					$item->setCustomName("§rWarp §a".$warp)
						 ->setLore(["\n§a>§b>§9§l§o Click To Teleport §r§b<§a<"])
				);
	        }
	    }
	    $menu->send($player);
	}

	public static function menuWarpGUIListener(InvMenuTransaction $transaction) : InvMenuTransactionResult {
        $player = $transaction->getPlayer();
        $action = $transaction->getAction();
        $plugin = WarpManager::getInstance();
		$warp = explode("§rWarp §a", $action->getInventory()->getItem($action->getSlot())->getName())[1];
        if($plugin->getWarp()->exists($warp)){
            $plugin->teleportToWarp($player, $warp);
            $msg = str_replace("{warp}", $warp, WarpGUI::getInstance()->getConfig()->get("msg-teleport"));
            $msg = ($msg != null) ? $msg : "§9[ §aSuccessfully §9]§r§e You have been teleported to the warp:§6 {warp}";
            $player->sendMessage($msg);
            return $transaction->discard();
        }
        return $transaction->discard();
	}
}
