<?php

/**
 * Description of CBHandler
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class CBHandler {

    public function __construct($channel) {
        privmsg($channel, 'cb command found');
    }
    
}
