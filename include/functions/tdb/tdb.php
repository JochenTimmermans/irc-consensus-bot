<?php

namespace jochent\ircConsensus\tdb;

/* TextDB functions */

/**
 * tdbCheck
 * 
 * Checks if tdb folder and files exists, if not, it creates them.
 */
function tdbCheck()
{
    // checking DIR
    if (!file_exists(TDB_DIR)) {
        console('TDB DIR not found. Creating now...');
        mkdir(TDB_DIR);
    }
    
    // checking Proposals file
    if (!file_exists(TDB_PROPOSALS)) {
        console('TDB_PROPOSALS not found. Creating now...');
        touch(TDB_PROPOSALS);
    }
    
    // checking Votes file
    if (!file_exists(TDB_VOTES)) {
        console('TDB_VOTES not found. Creating now...');
        touch(TDB_VOTES);
    }
}