/** 
 *    CREATE
 *
 *  Creates all databases needed for the bot to function 
 *
 * Author:  jfreeman82 <jfreeman@skedaddling.com>
 * Created: Sep 18, 2017
 */

/* Database */
DROP DATABASE IF EXISTS consensusbot;
CREATE DATABASE consensusbot;
USE consensusbot;
/* User */
DROP USER 'consensusbot'@'localhost';
CREATE USER 'consensusbot'@'localhost' IDENTIFIED BY 'consensusbot12345';
GRANT ALL ON consensusbot.* to 'consensusbot'@'localhost';

/* Proposals table */
DROP TABLE IF EXISTS proposals;
CREATE TABLE proposals (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  channel TEXT,
  vote_type INT,
  proposing_user_nick TEXT,
  proposing_user_host TEXT,
  target_user_nick TEXT,
  target_user_host TEXT,
  proposal_time DATETIME,
  end_time DATETIME
);

/* Votes table */
DROP TABLE IF EXISTS votes;
CREATE TABLE votes (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  proposal_id INT,
  voting_user_nick TEXT,
  voting_user_host TEXT, 
  voting_result TINYINT(1),
  vote_time DATETIME,
  FOREIGN KEY (proposal_id) REFERENCES proposals(id)
);

