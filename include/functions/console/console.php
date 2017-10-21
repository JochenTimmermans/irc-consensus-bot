<?php

namespace jochent\ircConsensus\console;

/**
 * console
 * 
 * Outputs $message to terminal
 * 
 * @param string $message
 * @return void
 */
function console(string $message) 
{ 
    echo $message."\r\n"; 
}

