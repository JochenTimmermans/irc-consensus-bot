<?php

/**
 * Description of Proposal
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class Proposal {

    private $id;
    private $channel;
    private $vote_type;
    private $proposing_user_nick;
    private $proposing_user_host;
    private $target_user_nick;
    private $target_user_host;
    private $proposal_time;
    private $end_time;
    
    public function __construct($proposal_id)
    {
        $sql = "SELECT channel,vote_type,proposing_user_nick,proposing_user_host,
                        target_user_nick,target_user_host,proposal_time,end_time 
                FROM proposals 
                WHERE id = '$proposal_id';";
        $dbc = new DBC();
        $q = $dbc->query($sql) or die("ERROR @ Proposal - ".$dbc->error());
        $row = $q->fetch_assoc();
        $this->id = $proposal_id;
        $this->channel = $row['channel'];
        $this->vote_type = $row['vote_type'];
        $this->proposing_user_nick = $row['proposing_user_nick'];
        $this->proposing_user_host = $row['proposing_user_host'];
        $this->target_user_nick = $row['target_user_nick'];
        $this->target_user_host = $row['target_user_host'];
        $this->proposal_time = $row['proposal_time'];
        $this->end_time = $row['end_time'];
    }

    // getters
    public function id()                { return $this->id; }
    public function channel()           { return $this->channel; }
    public function voteType()          { return $this->vote_type; }
    public function proposingUserNick() { return $this->proposing_user_nick; }
    public function proposingUserHost() { return $this->proposing_user_host; }
    public function targetUserNick()    { return $this->target_user_nick; }
    public function targetUserHost()    { return $this->target_user_host; }
    public function proposalTime()      { return $this->proposal_time; }
    public function endTime()           { return $this->end_time; }
       
}