<?php

/**
 * Description of Vote
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class Vote {

    private $id;
    private $proposal_id;
    private $voting_user_nick;
    private $voting_user_host;
    private $voting_result;
    private $vote_time;
    
    public function __construct($vote_id)
    {
        $sql = "SELECT proposal_id,voting_user_nick,voting_user_host,
                    voting_result,vote_time 
                FROM votes
                WHERE id = '$vote_id';";
        $dbc = new DBC();
        $q = $dbc->query($sql) or die("ERROR @ Vote - ".$dbc->error());
        $row = $q->fetch_assoc();
        $this->id = $vote_id;
        $this->proposal_id =        $row['proposal_id'];
        $this->voting_user_nick =   $row['voting_user_nick'];
        $this->voting_user_host =   $row['voting_user_host'];
        $this->voting_result =      $row['voting_result'];
        $this->vote_time =          $row['vote_time'];
    }
    
    // getters
    public function id()                { return $this->id;                 }
    public function proposalId()        { return $this->proposal_id;        }
    public function votingUserNick()    { return $this->voting_user_nick;   }
    public function votingUserHost()    { return $this->voting_user_host;   }
    public function votingResult()      { return $this->voting_result;      }
    public function voteTime()          { return $this->vote_time;          }
    
    // secondary getters
    public function proposalObj() { return new Proposal($this->proposal_id); }
}
