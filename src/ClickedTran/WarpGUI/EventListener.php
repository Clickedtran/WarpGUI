<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI;

use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerChatEvent;

use ClickedTran\WarpGUI\manager\WarpManager;

class EventListener implements Listener {
    public $plugin;
    public function __construct(WarpGUI $plugin){
         $this->plugin = $plugin;
    }
  
    public function onChat(PlayerChatEvent $event){
		$player = $event->getPlayer();
		if(isset(WarpManager::getInstance()->editwarp[$player->getName()])){
			$event->cancel();
			$args = explode(" ", $event->getMessage());
			$warp = WarpManager::getInstance()->editwarp[$player->getName()];
			switch($args[0]){
				case "help":
				case "?":
				    $player->sendMessage("§6> All Edit Commands <");
				    $player->sendMessage("§l§7help§r§7 - Display available commands");
				    $player->sendMessage("§l§7position§r§7 - Update the new position warp");
				    $player->sendMessage("§l§7name§r§7 - Update the name warp");
				    $player->sendMessage("§l§7item§r§7 - Update the item in gui warp");
				    $player->sendMessage("§l§7slot§r§7 - Update the slot in gui warp");
				    $player->sendMessage("§l§7done§r§7- Save and leave edit mode");
				break;
				case "position":
				case "location":
				    $x = round($player->getPosition()->getX());
				    $y = round($player->getPosition()->getY());
				    $z = round($player->getPosition()->getZ());
				    $world = $player->getPosition()->getWorld()->getDisplayName();
				    if(WarpManager::getInstance()->getWarp()->exists($warp)){
				        WarpManager::getInstance()->getWarp()->set($warp, [
                                             "position" => "$x $y $z",
                                             "world" => "$world",
                                             "item" => WarpManager::getInstance()->getWarp()->get($warp)["item"],
                                             "slot" => WarpManager::getInstance()->getWarp()->get($warp)["slot"]
		                        ]);
		                WarpManager::getInstance()->getWarp()->save();
		                $player->sendMessage("§9[ §aSuccessfully §9]§r§e You updated position in X: $x Y: $y Z: $z World: $world");
		            }else{
		            	$player->sendMessage("§9[ §4ERROR §9]§r§c The warp you are editing no longer exists in the data");
		            }
		        break;
		        case "name":
		            if(!isset($args[1])){
		            	$player->sendMessage("§cUsage:§7 name <name>");
		            	return;
		            }
		            if(!WarpManager::getInstance()->getWarp()->exists($args[1])){
		                $ex = explode(" ", WarpManager::getInstance()->getPositionWarps($warp));
		                $x = (int)$ex[0];
		                $y = (int)$ex[1];
		                $z = (int)$ex[2];
		                $world = WarpManager::getInstance()->getWorldWarps($warp);
			    	    WarpManager::getInstance()->getWarp()->set($args[1], [
                                     "position" => WarpManager::getInstance()->getWarp()->get($warp)["position"],
                                     "world" => WarpManager::getInstance()->getWarp()->get($warp)["world"],
                                     "item" => WarpManager::getInstance()->getWarp()->get($warp)["item"],
                                     "slot" => WarpManager::getInstance()->getWarp()->get($warp)["slot"]
			   	        ]);
		   		        WarpManager::getInstance()->getWarp()->save();
		   		        WarpManager::getInstance()->removeWarp($warp);
		                unset(WarpManager::getInstance()->editwarp[$player->getName()]);
		                WarpManager::getInstance()->editwarp[$player->getName()] = $args[1];
		                $player->sendMessage("§9[ §aSuccessfully §9]§r§e You have renamed the warp to §7$args[1]");
		           }else{
                        $player->sendMessage("§9[ §4ERROR §9]§r§c Warp name $args[1] is already exists");
		            }
                break;
                case "item":
				    if($player->getInventory()->getItemInHand() instanceof Item){
						$item = $player->getInventory()->getItemInHand();
					    if($item->isNull()){
							$player->sendMessage("§9[ §4ERROR §9]§r§c Please told item in your hand!");
							return;
						}
                        WarpManager::getInstance()->getWarp()->set($warp, [
                            "position" => WarpManager::getInstance()->getWarp()->get($warp)["position"],
                            "world" => WarpManager::getInstance()->getWarp()->get($warp)["world"],
                            "item" =>  WarpManager::getInstance()->itemToData($item),
                            "slot" => WarpManager::getInstance()->getWarp()->get($warp)["slot"]
                        ]);
                        WarpManager::getInstance()->getWarp()->save();
                        $player->sendMessage("§9[ §aSuccessfully §9]§r§e You have updated item warp in gui");
				    }
                break;
                case "slot":
                    if(isset($args[1])){
		                if(!is_numeric($args[1]) or $args[1] < 0 or !ctype_digit($args[1]) == "0."){
		                	$player->sendMessage("§cUsage:§7 slot <int: 0-26>");
		                	return;
		                }
		                if($args[1] >= 0 || $args[1] <= 26){
		                	$slot = (int)$args[1];
		                	$all_warp = WarpManager::getInstance()->getWarp()->getAll();
		                	foreach($all_warp as $data => $key){
		                	  if($slot !== $key["slot"]){
		                    WarpManager::getInstance()->getWarp()->set($warp, [
                                             "position" => WarpManager::getInstance()->getWarp()->get($warp)["position"],
                                             "world" => WarpManager::getInstance()->getWarp()->get($warp)["world"],
                                             "item" => WarpManager::getInstance()->getWarp()->get($warp)["item"],
                                             "slot" => $slot
                            	        ]);
				            	WarpManager::getInstance()->getWarp()->save();
								$player->sendMessage("§9[ §aSuccessfully §9]§r§e You have updated slot item in warp to $slot");
		                        return;
		                	  }else{
		                	    $player->sendMessage("§9[ §4ERROR §9]§r§c That slot already exists, please try again");
		                	    return;
		                	  }
		              	  }
		                }else{
		                    $player->sendMessage("§9[ §4ERROR §9]§r§c The number you enter can only be entered from 0 -> 53");
		                  return;
		                }
		            }else{
		            	$player->sendMessage("§cUsage:§7 slot <int: 0-26>");
		            	return;
		            }
                break;
                case "done":

                    if(WarpManager::getInstance()->getWarp()->get($warp)["item"] === ""){
                        $player->sendMessage("§9[ §4ERROR §9]§r§c Maybe you haven't set up: §bitem. §cPlease check and try again!");
                        return;
                    }
                    if(WarpManager::getInstance()->getWarp()->get($warp)["position"] === ""){
						$player->sendMessage("§9[ §4ERROR §9]§r§c Maybe you haven't set up: §bposition. §cPlease check and try again!");
					    return;
                    }

					if(WarpManager::getInstance()->getWarp()->get($warp)["slot"] === ""){
                        $player->sendMessage("§9[ §4ERROR §9]§r§c Maybe you haven't set up: §bslot. §cPlease check and try again!");
					    return;
                    }

                    if(isset(WarpManager::getInstance()->editwarp[$player->getName()])){
                    	unset(WarpManager::getInstance()->editwarp[$player->getName()]);
                    	$player->sendMessage("§aYou have successfully left setup mode");
                    }
                break;
                default:
				$player->sendMessage("§6You are in setup mode, usage:");
				$player->sendMessage("§l§7help§r§7 - Display available commands");
				$player->sendMessage("§l§7done§r§7 - Save and leave setup mode");
                break;
			}
		}
	}
}
