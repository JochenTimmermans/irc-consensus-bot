<?php

namespace jochent\ircConsensus\irc;

use function jochent\ircConsensus\irc\commands\privmsg,
             jochent\ircConsensus\irc\user\extract_user_nick;

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
        //writeln("text0: '".$text[0]."'");
        if (trim($text[0]) == BOT_COMMAND) {        
            $user = $data[0];
            $command = $data[1];
            $channel = $data[2];
            
            if (trim($text[1]) == "votekick") {
                if (isset($text[2])) {
                    $proposing = extract_user_nick($user);
                    $target = $text[2];
                    // check if target user exists, + check that target != proposing user
                    if (!in_array($target, $names)) { 
                        privmsg($channel, "User is not in ".$channel); 
                        writeln('target: '.$target);
                        writeln('names: "'.implode($names,', ').'"');
                        return; 
                    }
                    if ($target == $proposing) { privmsg($channel, "You cannot vote on yourself."); return; }
                    if ($target == BOT_NICK) { privmsg($channel, "You cannot vote for me, sorry."); return;}
                    writeln('proposing: '.$proposing);
                    writeln('target: '.$target);
                    privmsg($channel, 'Kick vote started on '.$target);
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