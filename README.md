## 📋 General

| **Plugins** | **WarpGUI** |
| --- | --- |
| **API** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.api/WarpGUI"></a>** |
| **Version** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.state/WarpGUI"></a>** |
| **Download** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.dl/WarpGUI"></a>** |
| **Total Download** | **<a href="https://poggit.pmmp.io/p/WarpGUI"><img src="https://poggit.pmmp.io/shield.dl.total/WarpGUI"></a>** |
<br>


<div align="center">
<img src="https://github.com/Clickedtran/WarpGUI-PM4/blob/Master/icon.png" width="300px" height="auto">
</div>
<br>

<p align="center">✔️ The plugin allows you to create and edit warps ✔️</p>
<br>
<p align="center">✔️ Can add or remove more areas ✔️</p>
<br>

## 📖 Features
- It's a plugin that allows you to navigate using the chest menu
- The plugin is inspired by the WarpGUI of Minecraft PC

<br>

## Credits / Virions Used
- [InvMenu](https://github.com/Muqsit/InvMenu) (Muqsit)
- [DEVirion](https://github.com/poggit/devirion) (SOF3)
- [Commando](https://github.com/Paroxity/Commando) (Paroxity)
- [SimplePacketHandler](https://github.com/muqsit/SimplePacketHandler) (Muqsit)

<br>

## 💬 Commands
| **Commands** | **Description** | **Aliases** |
| --- | --- | --- |
| **/warpgui** | **WarpGUI Commands** | **/warp** |

<br>

## 📝 Permission

<details> 
  <summary>Click to see permission</summary>

- use permission `warpgui.command` to use command /warpgui
- use permission `warpgui.command.help` to use command /warpgui help
- use permission `warpgui.command.create` to use command /warpgui create
- use permission `warpgui.command.remove` to use command /warpgui remove
- use permission `warpgui.command.setup` to use command /warpgui setup
- use permission `warpgui.command.list` to use command /warpgui list

</details>

<br>

## 📜 Config

<details>
  <summary>Click to open</summary>

```yaml
---
# WarpGUI config.yml
#    
#    ░██╗░░░░░░░██╗░█████╗░██████╗░██████╗░░██████╗░██╗░░░██╗██╗
#    ░██║░░██╗░░██║██╔══██╗██╔══██╗██╔══██╗██╔════╝░██║░░░██║██║
#    ░╚██╗████╗██╔╝███████║██████╔╝██████╔╝██║░░██╗░██║░░░██║██║
#    ░░████╔═████║░██╔══██║██╔══██╗██╔═══╝░██║░░╚██╗██║░░░██║██║
#    ░░╚██╔╝░╚██╔╝░██║░░██║██║░░██║██║░░░░░╚██████╔╝╚██████╔╝██║
#    ░░░╚═╝░░░╚═╝░░╚═╝░░╚═╝╚═╝░░╚═╝╚═╝░░░░░░╚═════╝░░╚═════╝░╚═╝
#
# Message Teleport To Warp
# Use {warp} to get warp name
msg-teleport: "§aSuccessfully teleport to warp§6 {warp}"

# Menu WarpGUI Name
menu-name: "WarpGUI"
...
```
</details>

---
## 📚 For Developer
### API
```php
$api = WarpManager::getInstance();
```
### Create New Warp
```php
$name = "fishing";

//check warp exists
if($api->getWarp()->exsits($name)){
   $player->sendMessage("warp already exists!");
   return;
}
$api->addWarp($name);
$player->sendMessage("Warp ".$name." has been created successfully");
```
### Remove Warp
```php
$name = "fishing";

if(!$api->getWarp()->exists($name)){
   $player->sendMessage("warp does not exists!");
   return;
}
$api->removeWarp($name);
$player->sendMessage("Warp ".$name." has been removed");
```
### Setup Warp
```php
/**
*@var Player $player
*/
$api->editWarp[$player->getName()];
```
### Teleport Player To Warp
```php
/**
*@var Player $player
*@var string $name
*/

$name = "fishing";
$api->teleportToWarp($player, $name);
```
<br>

## ▶️ Tutorial Setup
- [Click Here To See The Tutorial Setup](https://www.youtube.com/watch?v=KRF0pttAR04)
- IMPORTANT THING: You need to install the `DEVirion` plugin into the `plugins/` directory of the server, reload the server.

```yml
your_server_file
| - - plugins
|       ` - - WarpGUI
|       ` - - DEVirions
| - - virions
|       ` - - InvMenu
|       ` - - Commando
|       ` - - SimplePacketHandler
```


<br>

## Install
>- Step 1: Click the `Direct Download` button to download the plugin
>- Step 2: move the file `WarpGUI.phar` into the file `plugins`
>- Step 3: Restart server

<br>
