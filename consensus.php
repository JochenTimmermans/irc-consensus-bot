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
function notice($target,$message) {
    global $ircSocket;
    fwrite($ircSocket, "NOTICE ".$target." :".$message."\n");
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
function cleanStatus($name) {
    if (substr($name,0,1) == '@' || substr($name,0,1) == '+') {
        return substr($name,1);
    }
    else {
        return $name;
    }
}
/*  HOW TO READ TextDB files:
 * 
$myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($myfile)) {
  echo fgets($myfile) . "<br>";
}
fclose($myfile);
 * 
 */
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
            echo $data;

            // Separate all data
            $exData = explode(' ', $data);

            // Send PONG back to the server
            if($exData[0] == "PING") {
                writeln("PING ".$exData[1]);
                fwrite($ircSocket, "PONG ".$exData[1]."\n");                
            }
            
            // when $exData[3] == @, htis is the names list
            if (isset($exData[3]) && $exData[3] == '@' && $exData[4] == IRC_CHANNEL) {
                echo 'nameslist detected!';
                $nameslist = array_slice($exData, 5);
                // remove : from first item
                $nameslist[0] = substr($nameslist[0], 1);
                $names = array();
                foreach($nameslist as $name) {
                    $names[] = trim(cleanStatus($name));
                }
                writeln('names in my list:'.implode($names,','));
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
