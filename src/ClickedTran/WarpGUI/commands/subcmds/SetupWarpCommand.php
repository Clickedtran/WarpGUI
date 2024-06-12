<?php
declare(strict_types=1);
namespace ClickedTran\WarpGUI\commands\subcmds;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\RawStringArgument;

use ClickedTran\WarpGUI\manager\WarpManager;

class SetupWarpCommand extends BaseSubCommand{
  
  public function prepare(): void{
    $this->setPermission("warpgui.command.setup");
    $this->registerArgument(0, new RawStringArgument("warp name", true));
  }
  
  public function onRun(CommandSender $sender, String $aliasUsed, Array $args) : void{
    assert($sender instanceof Player);
    if(!isset($args["warp name"])){
      $sender->sendMessage("§9[ §4ERROR §9]§r§c Please input warp name to setup!");
      return;
    }
    
    if(!WarpManager::getInstance()->getWarp()->exists($args["warp name"])){
      $sender->sendMessage("§9[ §4ERROR §9]§r§c Warp with name §7".$args["warp name"]." §cdoes not exist. Please try again!");
      return;
    }
    
    WarpManager::getInstance()->editwarp[$sender->getName()] = ($args["warp name"]);
    $sender->sendMessage("§6You are in setup mode, usage:");
    $sender->sendMessage("§l§7help§r§7 - Display available commands");
    $sender->sendMessage("§l§7done§r§7 - save and leave edit mode");
  }
}