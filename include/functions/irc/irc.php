<?php

namespace freest\ircConsensus\irc\commands;

/**
 * Prints message to ircSocket
 * @param type $message
 */
function ircOut($message)
{
    global $ircSocket;    
    fwrite($ircSocket, $message."\n");
}
function privmsg($target,$message) {
    ircOut("PRIVMSG ".$target." :".$message);
}
function notice($target,$message) {
    ircOut("NOTICE ".$target." :".$message);
}
