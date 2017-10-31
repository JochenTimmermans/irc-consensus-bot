<?php

namespace freest\ircConsensus\votes;

use freest\db\DBC;

use function freest\ircConsensus\console\console;

function votekick_add($channel,$proposing_usernick, $proposing_userhost,$target_usernick,$target_userhost,$interval = 0)
{
    $vote_type = 1; 
    
    
    /** 
     * Data needed for insertion:
     * 
     * -+
| id                  | int(11)  | NO   | PRI | NULL    | auto_increment |
| channel             | text     | YES  |     | NULL    |                |
| vote_type           | int(11)  | YES  |     | NULL    |                |
| proposing_user_nick | text     | YES  |     | NULL    |                |
| proposing_user_host | text     | YES  |     | NULL    |                |
| target_user_nick    | text     | YES  |     | NULL    |                |
| target_user_host    | text     | YES  |     | NULL    |                |
| proposal_time       | datetime | YES  |     | NULL    |                |
| end_time            | datetime | YES  |     | NULL    |                
     */
    
    if ($interval == 0) { $interval = 1; } // day }
    $dbc = new DBC();
    $sql = "INSERT INTO proposals (channel,vote_type,proposing_user_nick,proposing_user_host,target_user_nick,target_user_host,proposal_time,end_time)
            VALUES ('$channel','$vote_type','$proposing_usernick','$proposing_userhost','$target_usernick','$target_userhost',NOW(), DATE_ADD(NOW(), INTERVAL $interval DAY));";
    $dbc->query($sql) or die("ERROR @ ".__FILE__." votekick_add : ".$dbc->error());
    console('vote inserted.');
}

