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

/* DB Settings 
define("MYSQL_HOST","localhost");
define("MYSQL_USER","consensusbot");
define("MYSQL_PASS","consensusbot12345");
define("MYSQL_DB","consensusbot");
*/
/* TextDB Settings */
define('TDB_DIR',       'tdb/');
define('TDB_PROPOSALS', TDB_DIR.'proposals.tdb');
define('TDB_VOTES',     TDB_DIR.'votes.tdb');

// Requires
require_once 'include/classes/CBHandler.php';
require_once 'include/classes/tdb/Proposal.php';
require_once 'include/classes/tdb/Vote.php';

require_once 'include/functions/console/console.php';
require_once 'include/functions/irc/irc.php';
require_once 'include/functions/irc/responses.php';
require_once 'include/functions/irc/user.php';
require_once 'include/functions/tdb/tdb.php';
