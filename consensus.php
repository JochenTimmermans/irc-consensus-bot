#!/usr/bin/php
<?php

namespace jochent\ircConsensus;

use jochent\ircConsensus\irc\CBHandler;

use function jochent\ircConsensus\console\console,
             jochent\ircConsensus\irc\commands\ircOut, 
             jochent\ircConsensus\irc\responses\hello,
             jochent\ircConsensus\irc\user\cleanStatus,
             jochent\ircConsensus\tdb\tdbCheck;             

require_once 'config.php';

console('Starting '.PROGRAM_NAME);
console('Config Loaded');

tdbCheck();

$ircSocket = fsockopen(IRC_SERVER, IRC_SERVER_POST, $errno, $errstr);

if ($ircSocket) {
    console("Connected to server.");
    ircOut("USER Lost rawr.test lol :code\n");
    ircOut("NICK " . BOT_NICK . "\n");
    ircOut("JOIN " . IRC_CHANNEL . "\n");

    while(1) {
        while($data = fgets($ircSocket, 128)) {
            echo $data;

            // Separate all data
            $exData = explode(' ', $data);

            // Send PONG back to the server
            if($exData[0] == "PING") {
                console("PING ".$exData[1]);
                ircOut("PONG ".$exData[1]."\n");                
            }
            
            // when $exData[3] == @, htis is the names list
            if (isset($exData[3]) && $exData[3] == '@' && $exData[4] == IRC_CHANNEL) {
                console('nameslist detected!');
                $nameslist = array_slice($exData, 5);
                // remove : from first item
                $nameslist[0] = substr($nameslist[0], 1);
                $names = array();
                foreach($nameslist as $name) {
                    $names[] = trim(cleanStatus($name));
                }
                console('names in my list:'.implode($names,','));
            }
            
            // example privmsg #channel:
            // :hythloday!~hythloday@ptr-178-50-86-230.dyn.mobistar.be PRIVMSG #consensus-bot :Hello conniebot

            if ($exData[1] == "PRIVMSG") {
                if ($exData[2] == IRC_CHANNEL) {
                    hello($exData);
                    new CBHandler($exData,$names);
                }
            }            
        }
    }
} else {
    echo $errstr . ": " . $errno;
}
