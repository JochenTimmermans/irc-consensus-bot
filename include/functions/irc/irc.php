<?php

namespace jochent\ircConsensus\irc\commands;

/**
 * Prints message to ircSocket
 * @param type $message
 */
function ircOut($message)
{
    global $ircSocket;    
    fwrite($ircSocket, $message);
}
function privmsg($target,$message) {
    ircOut("PRIVMSG ".$target." :".$message."\n");
}
function notice($target,$message) {
    ircOut("NOTICE ".$target." :".$message."\n");
}
