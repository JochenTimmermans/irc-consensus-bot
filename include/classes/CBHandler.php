<?php

namespace freest\ircConsensus\irc;

use function freest\ircConsensus\irc\commands\privmsg,
             freest\ircConsensus\irc\user\extract_user_nick,
             freest\ircConsensus\console\console,
             freest\ircConsensus\irc\commands\ircOut,
             freest\ircConsensus\votes\votekick_add;

/**
 * Description of CBHandler
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class CBHandler {

    public function __construct($data,$names = array()) {
        // already checked for privmsg + channel in main file        
        $text = $data;
        array_shift($text);
        array_shift($text);
        array_shift($text);

        $text[0] = substr($text[0],1); // clean the : from the first word
        //writeln(implode($text,' '));
        console("text0: '".$text[0]."'");
        if (trim($text[0]) == BOT_COMMAND) {     
            console("Botcommand!");
            $user = $data[0];
            $servercommand = trim($data[1]);
            $channel = $data[2];
            //console("command: '".$command."', channel: '".$channel."'");
            
            if (trim($text[1]) == "votekick") {
                console("Votekick detected.");
                if (isset($text[2])) {
                    $proposing = extract_user_nick($user);
                    $target = $text[2];
                    // check if target user exists, + check that target != proposing user
                    /*
                    if (!in_array($target, $names)) { 
                        privmsg($channel, "User is not in ".$channel); 
                        console('target: '.$target);
                        console('names: "'.implode($names,', ').'"');
                        return; 
                    }*/
                    if ($target == $proposing) { privmsg($channel, "You cannot vote on yourself."); return; }
                    if ($target == BOT_NICK) { privmsg($channel, "You cannot vote for me, sorry."); return;}
                    console('proposing: '.$proposing);
                    console('target: '.$target);
                    // update nameslist
//                    console("Refreshing names list.");
//                    ircOut("NAMES ".$channel);
                    global $users;
                    if (array_key_exists($target, $users)) {
                        console("User known, host is ".$users[$target]);
                        // votekick_add($channel,$proposing_usernick, $proposing_userhost,$target_usernick,$target_userhost,$interval = 0)
                        votekick_add($channel,$proposing, $users[$proposing], $target, $users[$target]);
                        privmsg($channel, 'Kick vote started on '.$target.'.');
                        privmsg($channel, 'Vote by using !cb vote <id> yes/no '.$target);
                    }
                    else {
                        privmsg($channel, "I don't know that user...");
                    }
                    
                    // notice all users 
                    // we cant get names list, or we won't drop into this cbhandler... hmmm.....
                }
                else {
                    $user_nick = extract_user_nick($user);
                    //notice($user_nick, 'please select a user to kick');
                    privmsg($channel, 'please select a user to kick');
                }
            }
        }
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