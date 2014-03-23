Plugin Outline
===
This plugin consists of several packages and subpackages. In each package/subpackage, there are several plugins that (can) work independently.

To maximize convenience in  customization, this plugin package is designed to work like checkbox groups. To disable the whole plugin, take away the main plugin. To disanle a particular package/subpackage, take away the file of the packsge's name into somewhere out of the `plugins/PocketRealisticMulti/code/classes/` folder. To disable a particular plugin, just take that particular file away. (This plugin uses a smart `if(class_exists("class"))` when the package tries to create an instance of that plugin/subpackage.

The current outline of PocketRealisticMulti:
1. Physics
  1. Gravity
  1. Relastic sound physics
  1. Ropes
1. Society
  1. Economy
  1. Philosophy
    * Birth handler
    * Death handler
1. Biology
  1. Realistic health
  1. NPCs




Copyright © 2014 PEMapModder, the Innovator of MCPE

You may copy these ideas for any non-commercial generally-legal purposes as long as you give the credit of the ideas to PEMapModder. If you are going to give any suggestions, please create an issue in [this repository](https://github.com/PEMapModder/PocketRealisticMulti).
