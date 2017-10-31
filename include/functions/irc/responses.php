<?php

namespace freest\ircConsensus\irc\responses;

use function freest\ircConsensus\irc\commands\privmsg,
             freest\ircConsensus\irc\user\extract_user_nick;

/**
 * hello
 * 
 * Returns hello <user> when greeted
 * 
 * @param string $data
 * @return void
 */
function hello(array $data) 
{
    $text = $data;
    array_shift($text);
    array_shift($text);
    array_shift($text);
    
    $text[0] = substr($text[0],1); // clean the : from the first word
    //writeln(implode($text,' '));
    //writeln("text0: '".$text[0]."'");
    if (isset($text[1])) {
        if (trim(strtolower($text[0])) == 'hello' && trim($text[1]) == BOT_NICK) {
            $user = $data[0];
            $channel = $data[2];
            privmsg($channel, "hello ".extract_user_nick($user));    
        }
    }
}
