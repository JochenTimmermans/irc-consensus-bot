#!/usr/bin/php
<?php

require_once 'config.php';

function writeln($message) { echo $message."\r\n"; }
function extract_user_nick($userblob) {
    //return 'Hyth';
    // remove first :
    $userblob = substr($userblob, 1);
    // cut until !
    $exc_pos = strpos($userblob,'!');
    return substr($userblob,0,$exc_pos);
}
function extract_user_username($userblob) {
    $exc_pos = strpos($userblob, '!') + 2;
    $at_pos = strpos($userblob, '@') - $exc_pos;
    return substr($userblob, $exc_pos, $at_pos);
}
function extract_user_host($userblob) {
    $at_pos = strpos($userblob, '@') + 1;
    return substr($userblob, $at_pos);
}
function privmsg($target,$message) {
    global $ircSocket;
    fwrite($ircSocket, "PRIVMSG ".$target." :".$message."\n");
}
function hello($data) {
    $text = $data;
    array_shift($text);
    array_shift($text);
    array_shift($text);
    
    $text[0] = substr($text[0],1); // clean the : from the first word
    //writeln(implode($text,' '));
    //writeln("text0: '".$text[0]."'");
    if (trim(strtolower($text[0])) == 'hello' && trim($text[1]) == BOT_NICK) {
        $user = $data[0];
        $channel = $data[2];
        privmsg($channel, "hello ".extract_user_nick($user));    
    }
}

function isCb($data) {
    $text = $data;
    array_shift($text);
    array_shift($text);
    array_shift($text);
    
    $text[0] = substr($text[0],1); // clean the : from the first word
    //writeln(implode($text,' '));
    //writeln("text0: '".$text[0]."'");
    if (trim($text[0]) == BOT_COMMAND) {
        return true;
    }
    return false;
}

writeln('Starting '.PROGRAM_NAME);
writeln('Config Loaded');

$ircSocket = fsockopen(IRC_SERVER, IRC_SERVER_POST, $errno, $errstr);

if ($ircSocket) {
    writeln("Connected to server.");
    fwrite($ircSocket, "USER Lost rawr.test lol :code\n");
    fwrite($ircSocket, "NICK " . BOT_NICK . "\n");
    fwrite($ircSocket, "JOIN " . IRC_CHANNEL . "\n");

    while(1) {
        while($data = fgets($ircSocket, 128)) {
            writeln($data);

            // Separate all data
            $exData = explode(' ', $data);

            // Send PONG back to the server
            if($exData[0] == "PING") {
                writeln("PING ".$exData[1]);
                fwrite($ircSocket, "PONG ".$exData[1]."\n");                
            }
            
            // example privmsg #channel:
            // :hythloday!~hythloday@ptr-178-50-86-230.dyn.mobistar.be PRIVMSG #consensus-bot :Hello conniebot

            if ($exData[1] == "PRIVMSG") {
                writeln("Caught PRIVMSG");
                if ($exData[2] == IRC_CHANNEL) {
                    writeln("PRIVMSG IN MY CHANNEL");
                    hello($exData);
                    if (isCb($exData)) {
                        new CBHandler($exData[2]);
                    }
                }
            }            
        }
    }
} else {
    echo $errstr . ": " . $errno;
}
