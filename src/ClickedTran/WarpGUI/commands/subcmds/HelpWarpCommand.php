<?php
declare(strict_types=1);
namespace ClickedTran\WarpGUI\commands\subcmds;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;

class HelpWarpCommand extends BaseSubCommand{
  
  public function prepare(): void{
    $this->setPermission("warpgui.command.help");
  }
  
  public function onRun(CommandSender $sender, String $aliasUsed, Array $args) : void{
    assert($sender instanceof Player);
    $sender->sendMessage("§6> All WarpGUI Commands <");
    $sender->sendMessage("§b/warpgui help §7- Display all command WarpGUI");
    $sender->sendMessage("§b/warpgui create §7- Add warp to data");
    $sender->sendMessage("§b/warpgui remove §7- Remove warp in data");
    $sender->sendMessage("§b/warpgui edit §7- Edit warp in data");
    $sender->sendMessage("§b/warpgui list §7- See all warp in data");
  }
}
