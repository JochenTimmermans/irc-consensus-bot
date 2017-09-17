#!/usr/bin/php
<?php


require_once 'config.php';

function writeln($message) { echo $message."\r\n"; }

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
            echo nl2br($data);
            flush();

            // Separate all data
            $exData = explode(' ', $data);

            // Send PONG back to the server
            if($exData[0] == "PING") {
                writeln("PING ".$exData[1]);
                fwrite($ircSocket, "PONG ".$exData[1]."\n");                
            }
        }
    }
} else {
    echo $errstr . ": " . $errno;
}
