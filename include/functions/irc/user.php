<?php

namespace freest\ircConsensus\irc\user;

/**
 * extract_user_nick
 * 
 * Extracts nickname from userblob
 * 
 * @param string $userblob
 * @return type
 */
function extract_user_nick(string $userblob) 
{
    //return 'Hyth';
    // remove first :
    $userblob = substr($userblob, 1);
    // cut until !
    $exc_pos = strpos($userblob,'!');
    return substr($userblob,0,$exc_pos);
}

/** extract_user_username
 * 
 * Extracts username from userblob
 * 
 * @param string $userblob
 * @return string
 */
function extract_user_username(string $userblob): string 
{
    $exc_pos = strpos($userblob, '!') + 2;
    $at_pos = strpos($userblob, '@') - $exc_pos;
    return substr($userblob, $exc_pos, $at_pos);
}

/** extract_user_host
 * Extracts user host from userblob
 * 
 * @param string $userblob
 * @return string
 */
function extract_user_host(string $userblob): string 
{
    $at_pos = strpos($userblob, '@') + 1;
    return substr($userblob, $at_pos);
}

/** cleanStatus
 * Cleans status from usernames
 * 
 * @param string $name
 * @return string
 */
function cleanStatus($name): string 
{
    if (substr($name,0,1) == '@' || substr($name,0,1) == '+') {
        return substr($name,1);
    }
    else {
        return $name;
    }
}
