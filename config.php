<?php

// Change these values to your taste
define('IRC_SERVER','irc.freenode.org');
define('IRC_SERVER_POST','6667');
define('IRC_CHANNEL','#consensus-bot'); 
define('BOT_NICK','c0nn13b0t');

define('BOT_COMMAND','!cb');

/* 
 *  DO NOT EDIT BEYOND THIS POINT
 */
ini_set('error_reporting', E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 'STDOUT');

define('PROGRAM_NAME','IRC CONSENSUS BOT');

/* DB Settings  */
define("MYSQL_HOST","localhost");
define("MYSQL_USER","consensusbot");
define("MYSQL_PASS","consensusbot12345");
define("MYSQL_DB","consensusbot");


// Requires
require_once 'include/classes/DBC.php';
require_once 'include/classes/CBHandler.php';
require_once 'include/classes/db/Proposal.php';
require_once 'include/classes/db/Vote.php';
require_once 'include/classes/User.php';

require_once 'include/functions/console/console.php';
require_once 'include/functions/db/votekick.php';
require_once 'include/functions/irc/irc.php';
require_once 'include/functions/irc/responses.php';
require_once 'include/functions/irc/user.php';
