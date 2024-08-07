<?php
// LD_Echo © 2024 by J Loiacano is licensed under CC BY-NC-SA 4.0 
// This can be edited.

define('LD_ECHO_DIRECTORY', __DIR__ . DIRECTORY_SEPARATOR); // Edit this path appropriately if this file is moved
define('LD_ECHO_MAIN_DIRECTORY', LD_ECHO_DIRECTORY . '_MAIN' . DIRECTORY_SEPARATOR);
define('LD_ECHO_EDITABLE_DIRECTORY', LD_ECHO_DIRECTORY . 'EDITABLE' . DIRECTORY_SEPARATOR);

require_once (LD_ECHO_MAIN_DIRECTORY . 'LD_Echo.php');
require_once (LD_ECHO_MAIN_DIRECTORY . 'LD_Echo_Tabs.php');
require_once (LD_ECHO_MAIN_DIRECTORY . 'LD_Echo_Output_Node.php');
require_once (LD_ECHO_MAIN_DIRECTORY . 'LD_Echo_Script.php');
require_once (LD_ECHO_MAIN_DIRECTORY . 'LD_Echo_Style.php');
require_once (LD_ECHO_MAIN_DIRECTORY . 'LD_Echo_HTML.php');
require_once (LD_ECHO_EDITABLE_DIRECTORY . 'LD_Echo_Inline_Style.php');
require_once (LD_ECHO_EDITABLE_DIRECTORY . 'LD_Echo_Echo_Ability.php');
require_once (LD_ECHO_EDITABLE_DIRECTORY . 'Dev.php');
