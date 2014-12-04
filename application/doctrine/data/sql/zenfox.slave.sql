SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `zenfox` ;
CREATE SCHEMA IF NOT EXISTS `zenfox` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE`zenfox`;

-- -----------------------------------------------------
-- Table `account_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `account_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `player_id` INT(11) NOT NULL ,
  `login` CHAR(50) NOT NULL ,
  `password` CHAR(50) NOT NULL ,
  `email` CHAR(255) NOT NULL ,
  `tracker_id` INT(11) NOT NULL DEFAULT '0' ,
  `buddy_id` INT(11) NOT NULL DEFAULT '0' ,
  `household_account_id` INT(11) NOT NULL ,
  `affiliate_scheme_id` INT(11) NOT NULL ,
  `affiliate_scheme_type` CHAR(10) NOT NULL ,
  `chat_status` ENUM('ENABLED', 'DISABLED', 'BANNED', 'BLACKLISTED') DEFAULT 'ENABLED' ,
  `chat_admin` ENUM('TRUE', 'FALSE') DEFAULT 'FALSE' ,
  `frontend_id` TINYINT(3) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `status` ENUM('ENABLED', 'DISABLED') DEFAULT 'ENABLED' ,
  `balance` FLOAT NOT NULL DEFAULT '0.00' ,
  `bank` FLOAT NOT NULL DEFAULT '0.00' ,
  `winnings` FLOAT NOT NULL DEFAULT '0.00' ,
  `cash` FLOAT NOT NULL DEFAULT '0.00' ,
  `bonus_bank` FLOAT NOT NULL DEFAULT '0.00' ,
  `bonus_winnings` FLOAT NOT NULL DEFAULT '0.00' ,
  `last_deposit` DATETIME NULL DEFAULT NULL ,
  `last_winning` DATETIME NULL DEFAULT NULL ,
  `last_wagered` DATETIME NULL DEFAULT NULL ,
  `last_withdrawal` DATETIME NULL DEFAULT NULL ,
  `last_login` DATETIME NULL ,
  `last_accessed_address` CHAR(255) NOT NULL ,
  `freegame` ENUM('TRUE', 'FALSE') DEFAULT 'TRUE' ,
  `bonusable` ENUM('TRUE', 'FALSE') DEFAULT 'TRUE' ,
  `loyalty_points_left` FLOAT NOT NULL DEFAULT '0.00' ,
  `total_loyalty_points` FLOAT NOT NULL DEFAULT '0.00' ,
  `language` CHAR(7) NOT NULL ,
  `base_currency` CHAR(3) NOT NULL ,
  `current_currency` CHAR(3) NOT NULL ,
  `max_daily_spending` FLOAT NOT NULL DEFAULT '-1' ,
  `todays_spendings` FLOAT NOT NULL ,
  `new_registration` ENUM('NEW', 'OLD') DEFAULT 'NEW' ,
  `acquired` ENUM('ACQUIRED', 'NOT_ACQUIRED') DEFAULT 'NOT_ACQUIRED' ,
  `acquired_date` DATETIME NOT NULL ,
  `tracker_earnings` FLOAT NOT NULL ,
  `buddy_earnings` FLOAT NOT NULL ,
  `total_deposits` FLOAT NOT NULL DEFAULT 0.00 ,
  `total_bonus` FLOAT NOT NULL DEFAULT 0.00 ,
  `max_deposit` FLOAT NULL ,
  `noof_deposits` INT NULL ,
  `max_bonus` FLOAT NULL ,
  `max_winnings` FLOAT NULL ,
  `bonus_scheme_id` INT(11) NOT NULL ,
  `timezone` CHAR(45) NULL ,
  PRIMARY KEY (`id`, `household_account_id`, `affiliate_scheme_id`) ,
  CONSTRAINT `player_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `account` (`player_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `language`
    FOREIGN KEY (`language` )
    REFERENCES `language` (`locale` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `base_currency`
    FOREIGN KEY (`base_currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `current_currency`
    FOREIGN KEY (`current_currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_scheme_id`
    FOREIGN KEY (`affiliate_scheme_id` )
    REFERENCES `affiliate_schemes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_scheme_id2`
    FOREIGN KEY (`affiliate_scheme_id` )
    REFERENCES `affiliate_scheme_def` (`scheme_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_scheme_type`
    FOREIGN KEY (`affiliate_scheme_type` )
    REFERENCES `ams_scheme_types` (`scheme_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `household_account_id`
    FOREIGN KEY (`household_account_id` )
    REFERENCES `account_details` (`player_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bonus_scheme_id`
    FOREIGN KEY (`bonus_scheme_id` )
    REFERENCES `bonus_schemes` (`scheme_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8
;

SHOW WARNINGS;
CREATE INDEX `player_id` ON `account_details` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `language` ON `account_details` (`language` ASC) ;

SHOW WARNINGS;
CREATE INDEX `base_currency` ON `account_details` (`base_currency` ASC) ;

SHOW WARNINGS;
CREATE INDEX `current_currency` ON `account_details` (`current_currency` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_scheme_id` ON `account_details` (`affiliate_scheme_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_scheme_id2` ON `account_details` (`affiliate_scheme_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_scheme_type` ON `account_details` (`affiliate_scheme_type` ASC) ;

SHOW WARNINGS;
CREATE INDEX `household_account_id` ON `account_details` (`household_account_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bonus_scheme_id` ON `account_details` (`bonus_scheme_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `login` ON `account_details` (`login` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `player_id_unique` ON `account_details` (`player_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `journal`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `journal` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `player_id` INT(11) NOT NULL ,
  `csr_id` INT(5) NOT NULL ,
  `note` CHAR(255) NOT NULL ,
  `created` DATETIME NOT NULL ,
  `last_edited` DATETIME NOT NULL ,
  PRIMARY KEY (`player_id`, `id`) ,
  CONSTRAINT `journal_player_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `account` (`player_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `player_details_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `account_details` (`player_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `player_id_index` ON `journal` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `journal_player_id` ON `journal` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `player_details_id` ON `journal` (`player_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ticket`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ticket` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ticket_status` ENUM('OPEN', 'CLOSE', 'PENDING', 'FORWARDED', 'DISPATCH') NULL ,
  `ticket_type_id` INT(2) NULL ,
  `subject` CHAR(255) NULL ,
  `user_id` INT NOT NULL ,
  `user_type` ENUM('AFFILIATE', 'PLAYER', 'VISITOR') NOT NULL ,
  `csr_id` INT NULL ,
  `csr_owner` INT NULL DEFAULT 0 ,
  `start_by` ENUM('AFFILIATE', 'PLAYER', 'CSR', 'VISITOR') NULL ,
  `started_id` INT NULL ,
  `closed_by` ENUM('AFFILIATE', 'PLAYER', 'CSR') NULL ,
  `closed_id` INT NULL ,
  `start_date` DATETIME NULL ,
  `close_date` DATETIME NULL ,
  `frontend_id` INT NULL ,
  PRIMARY KEY (`user_type`, `user_id`, `id`) ,
  CONSTRAINT `ticket_type_id`
    FOREIGN KEY (`ticket_type_id` )
    REFERENCES `ticket_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `csr_id`
    FOREIGN KEY (`csr_id` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `csr_owner`
    FOREIGN KEY (`csr_owner` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `user_id` ON `ticket` (`user_id` ASC, `user_type` ASC) ;

SHOW WARNINGS;
CREATE INDEX `csr` ON `ticket` (`csr_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ticket_type_id` ON `ticket` (`ticket_type_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `csr_id` ON `ticket` (`csr_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `csr_owner` ON `ticket` (`csr_owner` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ticket_data`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ticket_data` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ticket_id` INT NULL ,
  `ticket_type_id` INT NULL ,
  `reply_msg` TEXT NULL ,
  `dispatch` TINYINT(1) NULL ,
  `sent_by` ENUM('AFFILIATE', 'PLAYER', 'CSR') NULL ,
  `owner` INT NULL ,
  `time` DATETIME NULL ,
  `ticket_status` ENUM('OPEN', 'CLOSE', 'PENDING', 'FORWARDED', 'DISPATCH') NULL ,
  `note` CHAR(255) NULL ,
  `user_id` INT NOT NULL ,
  `user_type` ENUM('AFFILIATE', 'PLAYER', 'VISITOR') NOT NULL ,
  `frontend_id` INT NULL ,
  PRIMARY KEY (`user_type`, `user_id`, `id`) ,
  CONSTRAINT `ticket_data_ticket_type_id`
    FOREIGN KEY (`ticket_type_id` )
    REFERENCES `ticket_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `owner`
    FOREIGN KEY (`owner` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ticket_id`
    FOREIGN KEY (`user_type` , `user_id` , `ticket_id` )
    REFERENCES `ticket` (`user_type` , `user_id` , `id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `csr_id` ON `ticket_data` (`owner` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ticket_data_ticket_type_id` ON `ticket_data` (`ticket_type_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `owner` ON `ticket_data` (`owner` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ticket_id` ON `ticket_data` (`user_type` ASC, `user_id` ASC, `ticket_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `forwarded`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `forwarded` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ticket_id` INT NULL ,
  `forwarded_by` INT NULL ,
  `forwarded_to` INT NULL ,
  `forwarded_time` DATETIME NULL ,
  `forwarded_note` CHAR(255) NULL ,
  `user_id` INT NOT NULL ,
  `user_type` ENUM('AFFILIATE', 'PLAYER', 'VISITOR') NOT NULL ,
  PRIMARY KEY (`user_type`, `user_id`, `id`) ,
  CONSTRAINT `forwarded_by`
    FOREIGN KEY (`forwarded_by` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `forwarded_to`
    FOREIGN KEY (`forwarded_to` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ticket_id`
    FOREIGN KEY (`user_type` , `user_id` , `id` )
    REFERENCES `ticket` (`user_type` , `user_id` , `id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `user` ON `forwarded` (`user_id` ASC, `user_type` ASC) ;

SHOW WARNINGS;
CREATE INDEX `forwarded_by_index` ON `forwarded` (`forwarded_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `forwarded_to_index` ON `forwarded` (`forwarded_to` ASC) ;

SHOW WARNINGS;
CREATE INDEX `forwarded_by` ON `forwarded` (`forwarded_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `forwarded_to` ON `forwarded` (`forwarded_to` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ticket_id` ON `forwarded` (`user_type` ASC, `user_id` ASC, `id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `gamelog_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gamelog_sessions` (
  `id` INT NULL AUTO_INCREMENT ,
  `player_id` INT NULL ,
  `machine_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `frontend_id` INT NULL ,
  `auto_spin` TINYINT(1) NULL DEFAULT 0 ,
  `requested` INT NULL DEFAULT 0 ,
  `spun` INT NULL ,
  `wagered` FLOAT NULL ,
  `won` FLOAT NULL ,
  `amount_type` ENUM('REAL','BONUS','BOTH') NULL ,
  `currency` CHAR(3) NULL ,
  `session_start` DATETIME NULL ,
  `session_end` DATETIME NULL ,
  `ip_address` CHAR(20) NULL ,
  PRIMARY KEY (`player_id`, `id`) ,
  CONSTRAINT `running_slots_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `running_slots` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `running_roulette_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `running_roulette` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamelog_sessions_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `running_slots_id` ON `gamelog_sessions` (`machine_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `running_roulette_id` ON `gamelog_sessions` (`machine_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamelog_sessions_game_flavour` ON `gamelog_sessions` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `gamelog_roulette`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gamelog_roulette` (
  `log_id` INT NOT NULL AUTO_INCREMENT ,
  `session_id` INT NOT NULL ,
  `player_id` INT NULL ,
  `machine_id` INT NULL ,
  `bet_string` TEXT NULL ,
  `bet_amount` FLOAT NULL ,
  `win_number` INT NULL ,
  `win_string` CHAR(255) NULL ,
  `win_amount` FLOAT NULL ,
  `datetime` DATETIME NULL ,
  `amount_type` ENUM('REAL','BONUS','BOTH') NULL ,
  `pjp_winstatus` ENUM('WIN','NOWIN') DEFAULT 'NOWIN',
  `pjp_id` INT NULL ,
  `pjp_rng` INT NULL ,
  `pjp_win_amount` FLOAT NULL ,
  `wagered_currency` CHAR(3) NULL ,
  `running_machine_id` INT(11) ,
  `game_flavour` CHAR(45) ,
  `frontend_id` INT(4) ,
  PRIMARY KEY (`player_id`, `session_id`, `log_id`) ,
  CONSTRAINT `gamelog_roulette_player_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `account` (`player_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamelog_roulette_machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `running_roulette` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamelog_roulette_session`
    FOREIGN KEY (`player_id` , `session_id` )
    REFERENCES `gamelog_sessions` (`player_id` , `id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `wagered_currency`
    FOREIGN KEY (`wagered_currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `gamelog_roulette_player_id` ON `gamelog_roulette` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamelog_roulette_machine_id` ON `gamelog_roulette` (`machine_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamelog_roulette_session` ON `gamelog_roulette` (`player_id` ASC, `session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `wagered_currency` ON `gamelog_roulette` (`wagered_currency` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `player_transactions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS`player_transactions` (
  `source_id` int(11) NOT NULL auto_increment,
  `player_id` int(11) NOT NULL,
  `transaction_type` enum('AWARD_WINNINGS','CREDIT_DESPOSITS','PLACE_WAGER','CREDIT_BONUS') NOT NULL,
  `merchant_trans_id` int(11) default NULL,
  `card_id` int(11) default NULL,
  `game_flavour` char(45) default NULL,
  `running_machine_id` int(11) default NULL,
  `session_id` int(11) default NULL,
  `gamelog_id` int(11) default NULL,
  `amount` float default NULL,
  `amount_type` enum('REAL','BONUS','BOTH') default NULL,
  `transaction_currency` char(3) default NULL,
  `base_currency_amount` float default NULL,
  `base_currency` char(3) default NULL,
  `frontend_id` int(11) default NULL,
  `trans_start_time` datetime default NULL,
  `tracker_id` int(11) default NULL,
  `notes` char(255) default NULL,
  PRIMARY KEY  (`player_id`,`source_id`),
  KEY `player_transactions_player_id` (`player_id`),
  KEY `player_transactions_tracker_id` (`tracker_id`),
  KEY `game_group` (`game_flavour`,`running_machine_id`) ) 
ENGINE=MyISAM DEFAULT CHARSET=utf8
;
SHOW WARNINGS;
CREATE INDEX `player_transactions_player_id` ON `player_transactions` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `player_transactions_tracker_id` ON `player_transactions` (`tracker_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_group` ON `player_transactions` (`game_flavour` ASC, `running_machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `audit_report`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit_report` (
  `audit_id` int(11) NOT NULL auto_increment,
  `player_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `transaction_type` enum('AWARD_WINNINGS','CREDIT_DEPOSITS','PLACE_WAGER','CREDIT_BONUS') NOT NULL,
  `merchant_trans_id` int(11) default NULL,
  `card_id` int(11) default NULL,
  `game_flavour` char(45) default NULL,
  `running_machine_id` int(11) default NULL,
  `session_id` int(11) default NULL,
  `gamelog_id` int(11) default NULL,
  `amount` float default NULL,
  `amount_type` enum('REAL','BONUS','BOTH') default NULL,
  `transaction_currency` char(3) default NULL,
  `base_currency_amount` float default NULL,
  `base_currency` char(3) default NULL,
  `transaction_status` enum('PROCESSED','STARTED','ERROR','UNPROCESSED') default NULL,
  `notes` char(255) default NULL,
  `frontend_id` int(11) default NULL,
  `trans_start_time` datetime default NULL,
  `trans_end_time` datetime default NULL,
  `parent_id` int(11) default NULL,
  `processed` enum('PROCESSED','UNPROCESSED','STARTED') default 'PROCESSED',
  `error` enum('ERROR','NOERROR') default NULL,
  `cash_balance` float default NULL,
  `bb_balance` float default NULL,
  `real_change` float default NULL,
  `bonus_change` float default NULL,
  `tracker_id` int(11) default NULL,
  `conversion_rate` float default NULL,
  `converted_amount` float default NULL,
  `bonus_scheme_id` int(8) default NULL,
  `bonus_level_id` int(4) default NULL,
  `total_loyalty_points` float default NULL,
  `loyalty_points_left` float default NULL,
  PRIMARY KEY  (`player_id`,`audit_id`),
  KEY `source_trans_id` (`source_id`),
  KEY `audit_report_tracker_id` (`tracker_id`),
  KEY `game_group` (`game_flavour`,`running_machine_id`) )
ENGINE=MyISAM DEFAULT CHARSET=utf8
;
SHOW WARNINGS;
CREATE INDEX `source_trans_id` ON `audit_report` (`source_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `audit_report_tracker_id` ON `audit_report` (`tracker_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_group` ON `audit_report` (`game_flavour` ASC, `running_machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `player_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `player_sessions` (
  `player_id` INT NOT NULL ,
  `login` CHAR(50) NULL ,
  `ip_address` CHAR(45) NULL ,
  `login_time` DATETIME NULL ,
  `last_activity` TIMESTAMP NULL ,
  `session_expiry` DATETIME NULL ,
  `phpsessid` CHAR(255) NULL ,
  `frontend_id` INT NULL ,
  `player_frontend_id` INT NULL ,
  PRIMARY KEY (`player_id`) ,
  CONSTRAINT `account_details`
    FOREIGN KEY (`player_id` , `login` )
    REFERENCES `account_details` (`player_id` , `login` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `frontend_id`
    FOREIGN KEY (`frontend_id` )
    REFERENCES `frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `player_frontend_id`
    FOREIGN KEY (`player_frontend_id` , `player_id` )
    REFERENCES `account_details` (`frontend_id` , `player_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MEMORY
;

SHOW WARNINGS;
CREATE INDEX `account_details` ON `player_sessions` (`player_id` ASC, `login` ASC) ;

SHOW WARNINGS;
CREATE INDEX `frontend_id` ON `player_sessions` (`frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `player_frontend_id` ON `player_sessions` (`player_frontend_id` ASC, `player_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `sfs_logins`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sfs_logins` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `player_id` INT NOT NULL ,
  `login` CHAR(50) NOT NULL ,
  `game_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `sfs_userid` INT NULL ,
  `sfs_login` CHAR(100) NULL ,
  `sfs_zone` CHAR(100) NULL ,
  `sfs_roomid` INT NULL ,
  `sfs_hashkey` CHAR(32) NULL ,
  PRIMARY KEY (`id`, `player_id`, `login`) ,
  CONSTRAINT `account_details`
    FOREIGN KEY (`player_id` , `login` )
    REFERENCES `account_details` (`player_id` , `login` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MEMORY
;

SHOW WARNINGS;
CREATE INDEX `account_details` ON `sfs_logins` (`player_id` ASC, `login` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `gamelog_keno`
-- -----------------------------------------------------

CREATE TABLE `gamelog_keno` (
  `log_id` int(11) NOT NULL auto_increment,
  `session_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL default '0',
  `machine_id` int(11) default NULL,
  `frontend_id` int(11) default NULL,
  `bet_amount` float default NULL,
  `generated_numbers` char(255) default NULL,
  `selected_numbers` char(255) default NULL,
  `win_string` char(255) default NULL,
  `win_amount` float default NULL,
  `datetime` datetime default NULL,
  `amount_type` enum('REAL','BONUS','BOTH') default NULL,
  `pjp_winstatus` enum('WIN','NOWIN') default 'NOWIN',
  `pjp_id` int(11) default NULL,
  `pjp_rng` int(11) default NULL,
  `pjp_win_amount` float default NULL,
  `wagered_currency` char(3) default NULL,
  `running_machine_id` int(11) NOT NULL default '0',
  `game_flavour` char(45) NOT NULL,
  `spin_type` enum('AUTO','NORMAL','BONUS','FEATURE') default NULL,
  PRIMARY KEY  (`player_id`,`session_id`,`log_id`),
  KEY `gamelog_keno_player_id` (`player_id`),
  KEY `gamelog_keno_machine_id` (`machine_id`),
  KEY `gamelog_keno_session` (`player_id`,`session_id`),
  KEY `wagered_currency` (`wagered_currency`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `gamelog_slots`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gamelog_slots` (
  `log_id` INT NOT NULL ,
  `session_id` INT NOT NULL ,
  `player_id` INT NOT NULL ,
  `wagered_currency` CHAR(3) NULL ,
  PRIMARY KEY (`player_id`, `session_id`, `log_id`) ,
  CONSTRAINT `gamelog_slots_gamelog_session`
    FOREIGN KEY (`player_id` , `session_id` )
    REFERENCES `gamelog_sessions` (`player_id` , `id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamelog_slots_player_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `account_details` (`player_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `wagered_currency`
    FOREIGN KEY (`wagered_currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `gamelog_slots_gamelog_session` ON `gamelog_slots` (`player_id` ASC, `session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamelog_slots_player_id` ON `gamelog_slots` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `wagered_currency` ON `gamelog_slots` (`wagered_currency` ASC) ;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- CREATE SCHEMA IF NOT EXISTS `zenfox` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
-- USE`zenfox`;

-- -----------------------------------------------------
-- Table `country`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `country` (
  `id` INT NOT NULL ,
  `country` CHAR(100) NULL ,
  `country_code` CHAR(2) NULL ,
  `numcode` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE UNIQUE INDEX `country_code` ON `country` (`country_code` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `numcode` ON `country` (`numcode` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `language` (
  `id` INT NOT NULL ,
  `language` CHAR(45) NULL ,
  `locale` CHAR(7) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE UNIQUE INDEX `locale` ON `language` (`locale` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `currency`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `currency` (
  `currency_code` CHAR(3) NOT NULL ,
  `currency` CHAR(45) NULL ,
  `symbol` CHAR(5) NULL ,
  `currency_description` CHAR(255) NULL ,
  PRIMARY KEY (`currency_code`) )
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE UNIQUE INDEX `currency_code` ON `currency` (`currency_code` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bonus_schemes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bonus_schemes` (
  `scheme_id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`scheme_id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `no_payment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `no_payment` (
  `player_id` INT(11) NOT NULL ,
  `payment_type_not_allowed` INT(4) NOT NULL ,
  CONSTRAINT `no_payment_player_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `account` (`player_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM

DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `player_id_index` ON `no_payment` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `no_payment_player_id` ON `no_payment` (`player_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `country_language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `country_language` (
  `id` INT NOT NULL ,
  `country_code` CHAR(2) NULL ,
  `locale` CHAR(7) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `country_code`
    FOREIGN KEY (`country_code` )
    REFERENCES `country` (`country_code` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `locale`
    FOREIGN KEY (`locale` )
    REFERENCES `language` (`locale` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `country_code` ON `country_language` (`country_code` ASC) ;

SHOW WARNINGS;
CREATE INDEX `locale` ON `country_language` (`locale` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `country_currency`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `country_currency` (
  `id` INT NOT NULL ,
  `country_code` CHAR(2) NULL ,
  `currency_code` CHAR(3) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `country_currency_country_code`
    FOREIGN KEY (`country_code` )
    REFERENCES `country` (`country_code` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `currency_code`
    FOREIGN KEY (`currency_code` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `country_currency_country_code` ON `country_currency` (`country_code` ASC) ;

SHOW WARNINGS;
CREATE INDEX `currency_code` ON `country_currency` (`currency_code` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `flavours`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `flavours` (
  `id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `description` CHAR(45) NULL ,
  `game_flavour` CHAR(45) NOT NULL ,
  `main_table` CHAR(255) NULL ,
  `running_table` CHAR(255) NULL ,
  `game_log_table` CHAR(255) NULL ,
  `pjp_link` CHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `flavour_code` ON `flavours` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `slots`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `slots` (
  `machine_id` INT NOT NULL ,
  `machine_name` CHAR(45) NULL ,
  `game_flavour` CHAR(45) NOT NULL ,
  `feature_round` ENUM('ENABLED','DISABLED') NULL ,
  `bonus_spins` ENUM('ENABLED','DISABLED') NULL ,
  `max_coins` SMALLINT NULL ,
  `max_lines` SMALLINT NULL ,
  `min_coins` SMALLINT NULL DEFAULT 1 ,
  `min_lines` SMALLINT NULL DEFAULT 1 ,
  `pjp` ENUM('ENABLED','DISABLED') NULL ,
  `config_file` CHAR(255) NULL ,
  `swf_file` CHAR(255) NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`machine_id`) ,
  CONSTRAINT `game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `game_flavour` ON `slots` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `running_slots`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `running_slots` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `machine_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `amount_type` ENUM('REAL','BONUS','BOTH') NULL ,
  `feature_enabled` ENUM('ENABLED','DISABLED') NULL ,
  `bonus_spins_enabled` ENUM('ENABLED','DISABLED') NULL ,
  `denomination` CHAR(255) NULL ,
  `default_denomination` INT NULL ,
  `default_currency` CHAR(3) NULL ,
  `pjp_enabled` ENUM('ENABLED','DISABLED') NULL ,
  `max_bet` FLOAT NULL ,
  `machine_type` INT NULL ,
  `max_betlines` INT NULL ,
  `max_coins` INT NULL ,
  `min_betlines` INT NULL ,
  `min_coins` INT NULL ,
  `enabled` ENUM('ENABLED','DISABLED') NULL ,
  `created_by` INT NULL ,
  `created_time` DATETIME NULL ,
  `last_updated_by` INT NULL ,
  `last_updated_time` DATETIME NULL ,
  `description` CHAR(255) NULL ,
  `machine_name` CHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `slots` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `currency`
    FOREIGN KEY (`default_currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `created_by`
    FOREIGN KEY (`created_by` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `last_updated_by`
    FOREIGN KEY (`last_updated_by` )
    REFERENCES `csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `slots` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `machine_id` ON `running_slots` (`machine_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `currency` ON `running_slots` (`default_currency` ASC) ;

SHOW WARNINGS;
CREATE INDEX `created_by` ON `running_slots` (`created_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `last_updated_by` ON `running_slots` (`last_updated_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_flavour` ON `running_slots` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `frontend` (
  `id` INT(3) NOT NULL ,
  `name` CHAR(255) NULL ,
  `description` CHAR(255) NULL ,
  `site_code` CHAR(3) NULL ,
  `contact` CHAR(255) NULL ,
  `url` CHAR(255) NULL ,
  `ams_url` CHAR(255) NULL ,
  `gms_url` CHAR(255) NULL ,
  `status` TINYINT(1) NULL ,
  `affiliate_frontend_id` INT NULL ,
  `allowed_frontend_ids` CHAR(255) NULL ,
  `default_currency` CHAR(3) NOT NULL ,
  `secondary_currencies` CHAR(255) NULL ,
  `extra_field1` CHAR(255) NULL ,
  `extra_field2` CHAR(255) NULL ,
  `extra_field3` CHAR(255) NULL ,
  `default_bonus_scheme_id` INT NULL ,
  `timezone` CHAR(45) NULL ,
  `languages` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `affiliate_frontend_id`
    FOREIGN KEY (`affiliate_frontend_id` )
    REFERENCES `affiliate_frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `default_bonus_scheme_id`
    FOREIGN KEY (`default_bonus_scheme_id` )
    REFERENCES `bonus_schemes` (`scheme_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `default_currency`
    FOREIGN KEY (`default_currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `affiliate_frontend_id` ON `frontend` (`affiliate_frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `default_bonus_scheme_id` ON `frontend` (`default_bonus_scheme_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `default_currency` ON `frontend` (`default_currency` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `gamegroups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gamegroups` (
  `id` INT NOT NULL  ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `enabled` ENUM('ENABLED', 'DISABLED') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `name` ON `gamegroups` (`name` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `gamegroup_frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gamegroup_frontend` (
  `id` INT NOT NULL ,
  `frontend_id` INT(3) NULL ,
  `gamegroup_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `frontend_id`
    FOREIGN KEY (`frontend_id` )
    REFERENCES `frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamegroup_id`
    FOREIGN KEY (`gamegroup_id` )
    REFERENCES `gamegroups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `frontend_id` ON `gamegroup_frontend` (`frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamegroup_id` ON `gamegroup_frontend` (`gamegroup_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pjp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pjp` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pjp_name` VARCHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `currency` CHAR(3) NULL ,
  `bbs_enabled` ENUM('ENABLED', 'DISABLED') DEFAULT 'ENABLED' ,
  `bbs_pjp` FLOAT NULL ,
  `real_pjp` FLOAT NULL ,
  `random_number` INT NULL ,
  `seed` INT NULL ,
  `min_amount_bbs` FLOAT NULL ,
  `min_amount_real` FLOAT NULL ,
  `max_amount_bbs` FLOAT NULL ,
  `max_amount_real` FLOAT NULL ,
  `reset_close` ENUM('RESET', 'CLOSE') NULL DEFAULT 'CLOSE' ,
  `closed` ENUM('CLOSE', 'OPEN') DEFAULT 'CLOSE' ,
  `allowed_frontends` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `pjp_currency`
    FOREIGN KEY (`currency` )
    REFERENCES `currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `pjp_currency` ON `pjp` (`currency` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `machines_pjp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `machines_pjp` (
  `id` INT NOT NULL  ,
  `pjp_id` INT NULL ,
  `running_machine_id` INT NOT NULL ,
  `enabled` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `slots_machine_id`
    FOREIGN KEY (`running_machine_id` )
    REFERENCES `running_slots` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `slots_machine_id` ON `machines_pjp` (`running_machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pjp_machines`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pjp_machines` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pjp_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `game_id` INT NULL ,
  `percent_real` FLOAT NULL ,
  `percent_bbs` FLOAT NULL ,
  `min_bet_real` FLOAT NULL ,
  `min_bet_bbs` FLOAT NULL ,
  `max_bet_real` FLOAT NULL ,
  `max_bet_bbs` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `game_id`
    FOREIGN KEY (`game_id` )
    REFERENCES `running_slots` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pjp_id`
    FOREIGN KEY (`pjp_id` )
    REFERENCES `pjp` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `game_id` ON `pjp_machines` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `pjp_id` ON `pjp_machines` (`pjp_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_flavour` ON `pjp_machines` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `slots_feature`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `slots_feature` (
  `id` INT NOT NULL  ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `machine_id` INT NULL ,
  `prizes` CHAR(255) NULL ,
  `total` CHAR(255) NULL ,
  `min_pick` INT NULL ,
  `max_pick` INT NULL ,
  `feature_type` TINYINT(1) NULL ,
  `combination` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `slots_featured_machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `slots` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `slots_featured_machine_id` ON `slots_feature` (`machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `slots_bonus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `slots_bonus` (
  `id` INT NOT NULL ,
  `bonus_spin_type` TINYINT(1) NULL ,
  `machine_id` INT NULL ,
  `spins_awarded` INT NULL ,
  `combination` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `slots_bonus_machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `slots` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `slots_bonus_machine_id` ON `slots_bonus` (`machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ticket_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ticket_type` (
  `id` INT NOT NULL ,
  `ticket_type_name` CHAR(255) NULL ,
  `ticket_type_description` CHAR(255) NULL ,
  `enabled` TINYINT(1) NULL ,
  `user_type` ENUM('AFFILIATE', 'PLAYER') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `roulette`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roulette` (
  `machine_id` INT NOT NULL ,
  `machine_name` CHAR(45) NULL ,
  `game_flavour` CHAR(45) NOT NULL ,
  `feature_round` ENUM('ENABLED', 'DISABLED') DEFAULT 'DISABLED' ,
  `bonus_spins` ENUM('ENABLED', 'DISABLED') DEFAULT 'DISABLED' ,
  `max_coins` SMALLINT NULL ,
  `max_points` SMALLINT NULL ,
  `min_coins` SMALLINT NULL DEFAULT 1 ,
  `min_points` SMALLINT NULL DEFAULT 1 ,
  `pjp` ENUM('ENABLED', 'DISABLED') DEFAULT 'DISABLED' ,
  `config_file` CHAR(255) NULL ,
  `swf_file` CHAR(255) NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`machine_id`) ,
  CONSTRAINT `roulette_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `roulette_game_flavour` ON `roulette` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `running_roulette`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `running_roulette` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `machine_name` VARCHAR(45) NULL ,
  `game_flavour` CHAR(45) NULL ,
  `description` VARCHAR(255) NULL ,
  `denominations` VARCHAR(255) NULL ,
  `max_bet` FLOAT NULL ,
  `max_bet_string` VARCHAR(255) NULL ,
  `enabled` ENUM('ENABLED', 'DISABLED') NULL ,
  `machine_id` INT NULL ,
  `pjp_enabled` ENUM('ENABLED', 'DISABLED') DEFAULT 'DISABLED' ,
  `amount_type` ENUM('REAL','BONUS','BOTH') NULL ,
  `default_denomination` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `running_roulette_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `running_roulette_machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `roulette` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `running_roulette_game_flavour` ON `running_roulette` (`game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `running_roulette_machine_id` ON `running_roulette` (`machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_rooms`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_rooms` (
  `id` INT NOT NULL  ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `allowed_game_flavours` CHAR(255) NULL ,
  `enabled` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `game_gamegroups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `game_gamegroups` (
  `id` INT NOT NULL ,
  `running_machine_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `gamegroup_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `roulette_games`
    FOREIGN KEY (`running_machine_id` , `game_flavour` )
    REFERENCES `running_roulette` (`id` , `game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `slots_games`
    FOREIGN KEY (`running_machine_id` , `game_flavour` )
    REFERENCES `running_slots` (`id` , `game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_rooms`
    FOREIGN KEY (`running_machine_id` )
    REFERENCES `bingo_rooms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `roulette_games` ON `game_gamegroups` (`running_machine_id` ASC, `game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `slots_games` ON `game_gamegroups` (`running_machine_id` ASC, `game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `machine_flavours` ON `game_gamegroups` (`game_flavour` ASC, `running_machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bonus_levels`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bonus_levels` (
  `scheme_id` INT NULL ,
  `level_id` INT NULL  AUTO_INCREMENT,
  `level_name` CHAR(45) NULL ,
  `min_points` INT NULL ,
  `max_points` INT NULL ,
  `bonus_percentage` INT NULL ,
  `fixed_bonus` FLOAT NULL ,
  `min_deposit` FLOAT NULL ,
  `min_total_deposit` FLOAT NULL ,
  `reward_times` INT NULL ,
  `description` CHAR(255) NULL ,
  `fixed_real` FLOAT NULL ,
  PRIMARY KEY (`level_id`, `scheme_id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `loyalty_factors`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `loyalty_factors` (
  `id` INT NOT NULL ,
  `scheme_id` INT NULL ,
  `level_id` INT NULL ,
  `gamegroup_id` INT NULL ,
  `wager_factor` FLOAT NULL ,
  `loyalty_per_dollar` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `bonus_level`
    FOREIGN KEY (`scheme_id` , `level_id` )
    REFERENCES `bonus_levels` (`scheme_id` , `level_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamegroup_id`
    FOREIGN KEY (`gamegroup_id` )
    REFERENCES `gamegroups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bonus_level` ON `loyalty_factors` (`scheme_id` ASC, `level_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamegroup_id` ON `loyalty_factors` (`gamegroup_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pattern`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pattern` (
  `id` INT NOT NULL  ,
  `name` CHAR(50) NULL ,
  `description` CHAR(255) NULL ,
  `pattern` CHAR(255) NULL ,
  `no_of_parts` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_gamelog`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_gamelog` (
  `id` INT NOT NULL  ,
  `name` CHAR(50) NOT NULL ,
  `description` CHAR(255) NULL ,
  `game_flavour` CHAR(45) NOT NULL ,
  `game_type` ENUM('VARIABLE', 'FIXED') NOT NULL ,
  `amount_type` ENUM('REAL', 'BBS', 'BOTH') NOT NULL ,
  `pot_type` ENUM('SEPERATE', 'COMBINED') NULL ,
  `pattern_id` INT NOT NULL ,
  `pattern` CHAR(255) NULL ,
  `no_of_parts` INT NOT NULL ,
  `card_price` FLOAT NOT NULL ,
  `min_cards` INT NOT NULL ,
  `max_cards` INT NOT NULL ,
  `free_ratio` FLOAT NULL DEFAULT 0.00 ,
  `buy_time` INT NOT NULL DEFAULT 60 ,
  `call_delay` INT NOT NULL DEFAULT 2 ,
  `pjp_enabled` TINYINT(1) NULL ,
  `prebuy_enabled` TINYINT(1) NULL ,
  `real_return` FLOAT NOT NULL DEFAULT 80 ,
  `bbs_return` FLOAT NOT NULL DEFAULT 80 ,
  `min_pot_real` FLOAT NOT NULL DEFAULT 0.00 ,
  `max_pot_real` FLOAT NOT NULL ,
  `min_pot_bbs` FLOAT NOT NULL DEFAULT 0.00 ,
  `max_pot_bbs` FLOAT NOT NULL ,
  `pjp_won` TINYINT(1) NULL ,
  `room_id` INT NULL ,
  `session_id` INT NOT NULL ,
  `game_id` INT NOT NULL ,
  `start_time` DATETIME NOT NULL ,
  `end_time` DATETIME NOT NULL ,
  `total_players` INT NULL ,
  `cards_bought` INT NOT NULL ,
  `cards_free` INT NOT NULL ,
  `cards_prebuy` INT NULL DEFAULT 0 ,
  `cards_prebuy_free` INT NULL DEFAULT 0 ,
  `total_sales_real` FLOAT NOT NULL ,
  `total_sales_bbs` FLOAT NOT NULL ,
  `total_prebuy_real` FLOAT NULL DEFAULT 0.00 ,
  `total_prebuy_bbs` FLOAT NULL DEFAULT 0.00 ,
  `call_sequence` CHAR(255) NOT NULL ,
  `pattern_name` CHAR(45) NOT NULL ,
  `game_status` ENUM('INIT', 'BUY', 'RUN', 'WIN', 'OTHER', 'SUCCESS', 'FAIL') NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `pattern`
    FOREIGN KEY (`pattern_id` )
    REFERENCES `pattern` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_gamelog_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `pattern` ON `bingo_gamelog` (`pattern_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_game_flavour` ON `bingo_gamelog` (`game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `session_id` ON `bingo_gamelog` (`session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamelog_sessions` ON `bingo_gamelog` (`id` ASC, `session_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `variable_pot`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `variable_pot` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `game_id` INT NULL ,
  `part_id` INT NULL ,
  `real_return` FLOAT NULL ,
  `bbs_return` FLOAT NULL ,
  `min_pot_real` FLOAT NULL ,
  `max_pot_real` FLOAT NULL ,
  `min_pot_bbs` FLOAT NULL ,
  `max_pot_bbs` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `variable_game_id_fk`
    FOREIGN KEY (`game_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `variable_game_id` ON `variable_pot` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `variable_game_id_fk` ON `variable_pot` (`game_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `fixed_pot`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fixed_pot` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `game_id` INT NULL ,
  `part_id` INT NULL ,
  `call_number` INT NULL ,
  `real_amount` FLOAT NULL ,
  `bbs_amount` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fixed_game_id_fk`
    FOREIGN KEY (`game_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `fixed_game_id` ON `fixed_pot` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fixed_game_id_fk` ON `fixed_pot` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `game_id_call` ON `fixed_pot` (`game_id` ASC, `call_number` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `category` (
  `id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `pre_buy_enabled` TINYINT(1) NULL ,
  `visible` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `game_category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `game_category` (
  `game_id` INT NOT NULL ,
  `category_id` INT NOT NULL ,
  PRIMARY KEY (`game_id`, `category_id`) ,
  CONSTRAINT `bingo_game_id`
    FOREIGN KEY (`game_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `category`
    FOREIGN KEY (`category_id` )
    REFERENCES `category` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `bingo_game_id` ON `game_category` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `category` ON `game_category` (`category_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_pjp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_pjp` (
  `id` INT NOT NULL  ,
  `game_id` INT NOT NULL ,
  `pjp_id` INT NOT NULL ,
  `percent_real` FLOAT NOT NULL DEFAULT 0.00 ,
  `percent_bbs` FLOAT NOT NULL DEFAULT 0.00 ,
  `part_id` INT NULL ,
  `max_no_of_calls` INT NULL ,
  `fixed_amount_real` FLOAT NULL DEFAULT 0.00 ,
  `fixed_amount_bbs` FLOAT NULL DEFAULT 0.00 ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `bingo_pjp_id`
    FOREIGN KEY (`pjp_id` )
    REFERENCES `pjp` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `bingo_pjp_id` ON `bingo_pjp` (`pjp_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_sessions` (
  `id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `desciption` CHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_games`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_games` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(50) NOT NULL ,
  `description` CHAR(255) NULL ,
  `game_flavour` CHAR(45) NOT NULL ,
  `game_type` ENUM('VARIABLE', 'FIXED') NOT NULL ,
  `amount_type` ENUM('REAL', 'BBS', 'BOTH') NOT NULL ,
  `pot_type` ENUM('SEPERATE', 'COMBINED') NULL ,
  `pattern_id` INT NOT NULL ,
  `no_of_parts` INT NOT NULL ,
  `card_price` FLOAT NOT NULL ,
  `min_cards` INT NOT NULL ,
  `max_cards` INT NOT NULL ,
  `free_ratio` FLOAT NULL DEFAULT 0.00 ,
  `buy_time` INT NOT NULL DEFAULT 60 ,
  `call_delay` INT NOT NULL DEFAULT 2 ,
  `pjp_enabled` ENUM('ENABLED', 'DISABLED') DEFAULT 'DISABLED' ,
  `prebuy_enabled` ENUM('ENABLED', 'DISABLED') DEFAULT 'ENABLED' ,
  `real_return` FLOAT NOT NULL DEFAULT 80 ,
  `bbs_return` FLOAT NOT NULL DEFAULT 80 ,
  `min_pot_real` FLOAT NOT NULL DEFAULT 0.00 ,
  `max_pot_real` FLOAT NOT NULL ,
  `min_pot_bbs` FLOAT NOT NULL DEFAULT 0.00 ,
  `max_pot_bbs` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `pattern`
    FOREIGN KEY (`pattern_id` )
    REFERENCES `pattern` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `pattern` ON `bingo_games` (`pattern_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_game_flavour` ON `bingo_games` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `session_game`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `session_game` (
  `session_id` INT NOT NULL ,
  `game_id` INT NOT NULL ,
  `sequence` INT NOT NULL  ,
  PRIMARY KEY (`session_id`, `game_id`, `sequence`) ,
  CONSTRAINT `bingo_session_id`
    FOREIGN KEY (`session_id` )
    REFERENCES `bingo_sessions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_session_game_id`
    FOREIGN KEY (`game_id` )
    REFERENCES `bingo_games` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `session_game` ON `session_game` (`session_id` ASC, `game_id` ASC, `sequence` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_session_id` ON `session_game` (`session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_session_game_id` ON `session_game` (`game_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `rooms_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rooms_session` (
  `room_id` INT NOT NULL ,
  `session_id` INT NULL ,
  `duration` INT NULL ,
  `sequence` INT NULL ,
  `day` INT NULL ,
  PRIMARY KEY (`room_id`, `session_id`, `sequence`) ,
  CONSTRAINT `bingo_room_id`
    FOREIGN KEY (`room_id` )
    REFERENCES `bingo_rooms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `room_session_id`
    FOREIGN KEY (`session_id` )
    REFERENCES `bingo_sessions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `unique` ON `rooms_session` (`room_id` ASC, `session_id` ASC, `sequence` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_room_id` ON `rooms_session` (`room_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `room_session_id` ON `rooms_session` (`session_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_gamelog_variable`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_gamelog_variable` (
  `bingo_gamelog_id` INT NOT NULL ,
  `part_id` INT NULL ,
  `real_return` FLOAT NULL ,
  `bbs_return` FLOAT NULL ,
  `min_pot_real` FLOAT NULL ,
  `max_pot_real` FLOAT NULL ,
  `min_pot_bbs` FLOAT NULL ,
  `max_pot_bbs` FLOAT NULL ,
  `real_pot` FLOAT NULL ,
  `bbs_pot` FLOAT NULL ,
  PRIMARY KEY (`bingo_gamelog_id`, `part_id`) ,
  CONSTRAINT `bingo_gamelog_id`
    FOREIGN KEY (`bingo_gamelog_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_id` ON `bingo_gamelog_variable` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_gamelog_fixed`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_gamelog_fixed` (
  `bingo_gamelog_id` INT NOT NULL ,
  `game_details` TEXT NULL ,
  `call_number` INT NULL ,
  `real_amount` INT NULL ,
  `bbs_amount` INT NULL ,
  `part_id` INT NULL ,
  `win_real` INT NULL ,
  `win_bbs` FLOAT NULL ,
  CONSTRAINT `bingo_gamelog_fixed_id`
    FOREIGN KEY (`bingo_gamelog_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_fixed_id` ON `bingo_gamelog_fixed` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ticket_sales`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ticket_sales` (
  `id` INT NOT NULL ,
  `bingo_gamelog_id` INT NULL ,
  `player_id` INT NULL ,
  `cards_bought` INT NULL ,
  `cards_free` INT NULL ,
  `boughtcards` TEXT NULL ,
  `freecards` TEXT NULL ,
  `game_flavour` INT NULL ,
  `amount_real` FLOAT NULL ,
  `amount_bbs` FLOAT NULL ,
  `audit_id` INT NULL ,
  `datetime` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `ticket_sales_bingo_gamelog_id`
    FOREIGN KEY (`bingo_gamelog_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ticket_sales_audit_id`
    FOREIGN KEY (`player_id` , `audit_id` )
    REFERENCES `audit_report` (`player_id` , `audit_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `ticket_sales_bingo_gamelog_id` ON `ticket_sales` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_player` ON `ticket_sales` (`bingo_gamelog_id` ASC, `player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ticket_sales_audit_id` ON `ticket_sales` (`player_id` ASC, `audit_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_winners`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_winners` (
  `bingo_gamelog_id` INT NOT NULL ,
  `part_id` INT NOT NULL ,
  `real_amount_won` FLOAT NULL ,
  `bbs_amount_won` FLOAT NULL ,
  `winners` CHAR(255) NULL ,
  `winning_ticket_data` TEXT NULL ,
  `call_num` INT NULL ,
  PRIMARY KEY (`bingo_gamelog_id`, `part_id`) ,
  CONSTRAINT `bingo_winners_log_id`
    FOREIGN KEY (`bingo_gamelog_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_winners_log_id` ON `bingo_winners` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `bingo_pjp_log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `bingo_pjp_log` (
  `bingo_gamelog_id` INT NOT NULL ,
  `pjp_id` INT NULL ,
  `pjp_status` ENUM('OPEN', 'CLOSE') NULL ,
  `pjp_real` FLOAT NULL ,
  `pjp_bbs` FLOAT NULL ,
  `percent_real` FLOAT NULL ,
  `percent_bbs` FLOAT NULL ,
  `real_contribution` FLOAT NULL ,
  `bbs_contribution` FLOAT NULL ,
  `game_flavour` INT NULL ,
  `win_status` ENUM('WIN', 'LOSE') NULL ,
  PRIMARY KEY (`bingo_gamelog_id`, `pjp_id`) ,
  CONSTRAINT `pjp_log_bingo_gamelog`
    FOREIGN KEY (`bingo_gamelog_id` )
    REFERENCES `bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `pjp_log_bingo_gamelog` ON `bingo_pjp_log` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pjp_winners`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pjp_winners` (
  `id` INT NOT NULL ,
  `gamelog_id` INT NULL ,
  `session_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `pjp_id` INT NULL ,
  `pjp_name` CHAR(45) NULL ,
  `pjp_real` FLOAT NULL ,
  `pjp_bbs` FLOAT NULL ,
  `timestamp` TIMESTAMP NULL ,
  `random_number` INT NULL ,
  `random_seed` INT NULL ,
  `player_id` INT NULL ,
  `ticket_data` CHAR(255) NULL ,
  `no_of_calls` INT NULL ,
  `part_id` INT NULL ,
  `room_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `bingo_gamelog_id`
    FOREIGN KEY (`gamelog_id` , `session_id` )
    REFERENCES `bingo_gamelog` (`id` , `session_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `slots_gamelog_id`
    FOREIGN KEY (`player_id` , `session_id` , `gamelog_id` )
    REFERENCES `gamelog_slots` (`player_id` , `session_id` , `log_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pjp_winner_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pjp_winners_pjp_id`
    FOREIGN KEY (`pjp_id` )
    REFERENCES `pjp` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_id` ON `pjp_winners` (`gamelog_id` ASC, `session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `slots_gamelog_id` ON `pjp_winners` (`player_id` ASC, `session_id` ASC, `gamelog_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `pjp_winner_game_flavour` ON `pjp_winners` (`game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `pjp_winners_pjp_id` ON `pjp_winners` (`pjp_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `resources`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `resources` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(255) NULL ,
  `resource_type` ENUM('REQUEST','GAME') NULL ,
  `parent_id` INT NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`parent_id` )
    REFERENCES `resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `parent_id` ON `resources` (`parent_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `name` ON `resources` (`name` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(255) NULL ,
  `role_type` ENUM('VISITOR', 'PLAYER', 'AFFILIATE', 'CSR') NULL ,
  `parent_id` INT NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`parent_id` )
    REFERENCES `roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `parent_id` ON `roles` (`parent_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `role` ON `roles` (`name` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `privileges`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `privileges` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `resource_id` INT NULL ,
  `resource_name` CHAR(255) NULL ,
  `resource_type` ENUM('REQUEST','GAME') NULL ,
  `role_id` INT NULL ,
  `role_name` CHAR(255) NULL ,
  `role_type` ENUM('VISITOR', 'PLAYER', 'AFFILIATE', 'CSR') NULL ,
  `mode` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `resources`
    FOREIGN KEY (`resource_id` , `resource_name` , `resource_type` )
    REFERENCES `resources` (`id` , `name` , `resource_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `roles`
    FOREIGN KEY (`role_id` , `role_name` , `role_type` )
    REFERENCES `roles` (`id` , `name` , `role_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `resources` ON `privileges` (`resource_id` ASC, `resource_name` ASC, `resource_type` ASC) ;

SHOW WARNINGS;
CREATE INDEX `roles` ON `privileges` (`role_id` ASC, `role_name` ASC, `role_type` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `wagering_rules`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `wagering_rules` (
  `id` INT NULL  ,
  `player_id` INT NULL ,
  `min_wager_amount` FLOAT NULL DEFAULT 0 ,
  `max_wager_amount` FLOAT NULL DEFAULT -1 ,
  `wagering_rule` CHAR(255) NULL ,
  `enabled` ENUM('ENABLED','DISABLED') NULL ,
  `rule_met` ENUM('MET','NOT_MET') NULL ,
  `added_time` DATETIME NULL ,
  `expiry_time` DATETIME NULL ,
  `expiry_rule` CHAR(255) NULL ,
  `deposited_amount` FLOAT NULL ,
  `audit_id` INT NULL ,
  `source_id` INT NULL ,
  PRIMARY KEY (`id`, `player_id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`keno`
-- -----------------------------------------------------

CREATE TABLE `keno` (
  `machine_id` int(11) NOT NULL,
  `machine_name` char(45) DEFAULT NULL,
  `game_flavour` char(45) NOT NULL,
  `feature_round` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `bonus_spins` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `max_coins` smallint(6) DEFAULT NULL,
  `max_nums` smallint(6) DEFAULT NULL,
  `min_coins` smallint(6) DEFAULT '1',
  `min_nums` smallint(6) DEFAULT '1',
  `machine_type` int(11) NOT NULL,
  `pjp` enum('ENABLED','DISABLED') DEFAULT 'DISABLED',
  `description` char(255) DEFAULT NULL,
  `config_file` char(255) DEFAULT NULL,
  `swf_file` char(255) DEFAULT NULL,
  PRIMARY KEY (`machine_id`),
  KEY `keno_game_flavour` (`game_flavour`) ) 
ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- -----------------------------------------------------
-- Table `zenfox`.`running_keno`
-- -----------------------------------------------------

CREATE TABLE `running_keno` (
  `id` int(11) NOT NULL,
  `machine_id` int(11) default NULL,
  `machine_name` varchar(45) default NULL,
  `game_flavour` char(45) default NULL,
  `description` varchar(255) default NULL,
  `denominations` varchar(255) default NULL,
  `default_denomination` float default NULL,
  `default_currency` varchar(255) default NULL,
  `max_bet` float default NULL,
  `enabled` enum('ENABLED','DISABLED') default NULL,
  `machine_type` int(11) default NULL,
  `amount_type` enum('REAL','BONUS','BOTH') default NULL,
  `pjp_enabled` enum('ENABLED','DISABLED') default 'DISABLED',
  `min_bet` float default NULL,
  `min_nums` int(4) default NULL,
  `min_coins` int(4) default NULL,
  `max_nums` int(4) default NULL,
  `max_coins` int(4) default NULL,
  PRIMARY KEY  (`id`),
  KEY `running_keno_game_flavour` (`game_flavour`),
  KEY `running_keno_machine_id` (`machine_id`) ) 
ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE  TABLE IF NOT EXISTS `zenfox`.`player_gateways` (
  `player_gateway_id` INT NOT NULL AUTO_INCREMENT ,
  `player_id` INT NOT NULL ,
  `gateway` VARCHAR(45) NOT NULL ,
  `status` TINYINT(1) NOT NULL DEFAULT 1 ,
  `date_added` DATETIME NOT NULL ,
  `frontend_id` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`player_gateway_id`) )
ENGINE = MyISAM;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `flavours`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;



COMMIT;

-- -----------------------------------------------------
-- Data for table `gamegroups`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;




COMMIT;

-- -----------------------------------------------------
-- Data for table `pjp`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;


COMMIT;

-- -----------------------------------------------------
-- Data for table `pjp_machines`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;


COMMIT;

-- -----------------------------------------------------
-- Data for table `category`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;


COMMIT;