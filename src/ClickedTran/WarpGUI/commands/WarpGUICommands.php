<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\commands;

use pocketmine\player\Player;
use pocketmine\command\CommandSender;
use pocketmine\Server;

use CortexPE\Commando\BaseCommand;

use ClickedTran\WarpGUI\WarpGUI;
use ClickedTran\WarpGUI\gui\GUIManager;
use ClickedTran\WarpGUI\commands\subcmds\HelpWarpCommand;
use ClickedTran\WarpGUI\commands\subcmds\ListWarpCommand;
use ClickedTran\WarpGUI\commands\subcmds\RemoveWarpCommand;
use ClickedTran\WarpGUI\commands\subcmds\SetupWarpCommand;
use ClickedTran\WarpGUI\commands\subcmds\CreateWarpCommand;

class WarpGUICommands extends BaseCommand {
    
    public function prepare(): void{
      $this->setPermission("warpgui.command");
      $this->registerSubcommand(new CreateWarpCommand("create", "§o§7Create New Warp Command"));
      $this->registerSubcommand(new HelpWarpCommand("help", "§o§7Help WarpGUI Command"));
      $this->registerSubcommand(new SetupWarpCommand("setup", "§o§7Setup Warp Command"));
      $this->registerSubcommand(new RemoveWarpCommand("remove", "§o§7Remoge Warp Command"));
      $this->registerSubcommand(new ListWarpCommand("list", "§o§7List Warp Command"));
    }
    
    public function onRun(CommandSender $sender, String $aliasUsed, Array $args): void{
      if(!$sender instanceof Player){
        $sender->sendMessage("§cPlease use in-game!");
        return;
      }
      if(count($args) === 0){
         $gui = new GUIManager();
         $gui->menuWarpGUI($sender);
      }
    }

    public function getPermission()
    {
        // TODO: Implement getPermission() method.
    }
}
