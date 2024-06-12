<?php
declare(strict_types=1);
namespace ClickedTran\WarpGUI\commands\subcmds;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\RawStringArgument;

use ClickedTran\WarpGUI\manager\WarpManager;

class CreateWarpCommand extends BaseSubCommand{
  
  public function prepare(): void{
    $this->setPermission("warpgui.command.create");
    $this->registerArgument(0, new RawStringArgument("warp name", true));
  }
  
  public function onRun(CommandSender $sender, String $aliasUsed, Array $args) : void{
    assert($sender instanceof Player);
    if(!isset($args["warp name"])){
      $sender->sendMessage("§9[ §4ERROR §9]§r§c Please input warp name!");
      return;
    }
    
    if(WarpManager::getInstance()->getWarp()->exists($args["warp name"])){
      $sender->sendMessage("§9[ §4ERROR §9]§r§c Warp with name §7".$args["warp name"]." §cis already exists. Try again!");
      return;
    }
    
    WarpManager::getInstance()->addWarp($args["warp name"]);
    $sender->sendMessage("§9[ §aSuccessfully §9]§r§e You have created warp with name §7".$args["warp name"]);
  }
}