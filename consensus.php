#!/usr/bin/php
<?php

namespace freest\ircConsensus;

use freest\ircConsensus\irc\CBHandler;

use function freest\ircConsensus\console\console,
             freest\ircConsensus\irc\commands\ircOut, 
             freest\ircConsensus\irc\responses\hello,
             freest\ircConsensus\irc\user\cleanStatus;             

require_once 'config.php';

console('Starting '.PROGRAM_NAME);
console('Config Loaded');

$ircSocket = fsockopen(IRC_SERVER, IRC_SERVER_POST, $errno, $errstr);


$users = array();

if ($ircSocket) {
    console("Connected to server.");
    ircOut("USER Lost rawr.test lol :code\n");
    ircOut("NICK " . BOT_NICK . "\n");
    ircOut("JOIN " . IRC_CHANNEL . "\n");
    
    while (1) {
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
                    $names[] = array('nick' => trim(cleanStatus($name)));
                }
                //console('names in my list:'.implode($names,','));
                // get whois info for names
                foreach ($names as $name) {
                    ircOut("WHOIS ".$name['nick']);
                }
            }
            
            
            if (isset($exData[1]) && trim($exData[1]) == "311") {
                console("311 Detected!");
                $user_nick = $exData[3];
                $user_host = $exData[5];
                $users[$user_nick] = $user_host;
            }
            /* To check known users: 
            console("Known Users: ");
            foreach (array_keys($users) as $user) {
                console($user ." @ ".$users[$user]);
            }
            */

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
