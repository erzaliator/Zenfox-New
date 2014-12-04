SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `zenfox` ;
CREATE SCHEMA IF NOT EXISTS `zenfox` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
SHOW WARNINGS;
USE`zenfox`;

-- -----------------------------------------------------
-- Table `zenfox`.`account`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`account` (
  `player_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `login` CHAR(50) NOT NULL ,
  `first_name` CHAR(50) NOT NULL ,
  `last_name` CHAR(50) NOT NULL ,
  `email` CHAR(255) NOT NULL ,
  `sex` CHAR(1) NOT NULL ,
  `dateofbirth` DATE NOT NULL ,
  `address` CHAR(255) NOT NULL ,
  `city` CHAR(50) NOT NULL ,
  `state` CHAR(50) NOT NULL ,
  `country` CHAR(2) NOT NULL ,
  `pin` CHAR(10) NOT NULL ,
  `phone` CHAR(20) NOT NULL ,
  `question` CHAR(255) NOT NULL ,
  `hint` CHAR(255) NOT NULL ,
  `answer` CHAR(255) NOT NULL ,
  `newsletter` TINYINT(1) NOT NULL DEFAULT '1' ,
  `promotions` TINYINT(1) NOT NULL DEFAULT '1' ,
  `black_list` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`player_id`) ,
  CONSTRAINT `country`
    FOREIGN KEY (`country` )
    REFERENCES `zenfox`.`country` (`country_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE UNIQUE INDEX `login` ON `zenfox`.`account` (`login` ASC) ;

SHOW WARNINGS;
CREATE INDEX `country` ON `zenfox`.`account` (`country` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `email` ON `zenfox`.`account` (`email` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`account_unconfirm`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `zenfox`.`account_unconfirm` (
  `player_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'This is different from the actual player_id' ,
  `login` CHAR(50) NOT NULL ,
  `first_name` CHAR(50) NOT NULL ,
  `last_name` CHAR(50) NOT NULL ,
  `email` CHAR(255) NOT NULL ,
  `sex` CHAR(1) NOT NULL ,
  `dateofbirth` DATE NOT NULL ,
  `address` CHAR(255) NOT NULL ,
  `city` CHAR(50) NOT NULL ,
  `state` CHAR(50) NOT NULL ,
  `country` CHAR(2) NOT NULL COMMENT 'Should this be numeric code (numcode) or should this be 3 letter ISO Code or 2 letter ISO code?' ,
  `pin` CHAR(10) NOT NULL ,
  `phone` CHAR(20) NOT NULL ,
  `question` CHAR(255) NOT NULL ,
  `hint` CHAR(255) NOT NULL ,
  `answer` CHAR(255) NOT NULL ,
  `newsletter` TINYINT(1) NOT NULL DEFAULT '1' ,
  `promotions` TINYINT(1) NOT NULL DEFAULT '1' ,
  `code` CHAR(45) NOT NULL ,
  `expiry_time` DATETIME NULL DEFAULT NULL ,
  `confirmation` ENUM('YES','NO') NULL DEFAULT 'NO' ,
  `password` CHAR(50) NULL DEFAULT NULL ,
  `tracker_id` INT(11) NULL DEFAULT '0' ,
  `buddy_id` INT(11) NULL DEFAULT '0' ,
  `frontend_id` INT(11) NOT NULL ,
  `created` DATETIME NULL DEFAULT NULL ,
  `last_accessed_address` CHAR(255) NULL DEFAULT NULL ,
  `bonusable` ENUM('TRUE','FALSE') NULL DEFAULT 'TRUE' ,
  `role_type` ENUM('PLAYER','AFFILIATE') NULL DEFAULT 'PLAYER' ,
  `affiliate_data` CHAR(1) NULL DEFAULT NULL ,
  PRIMARY KEY (`player_id`, `login`, `email`, `frontend_id`) ,
  INDEX `country` (`country` ASC) ,
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) )
ENGINE = MyISAM
AUTO_INCREMENT = 4601
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `zenfox`.`affiliate_schemes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`affiliate_schemes` (
  `id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `note` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`ams_scheme_types`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`ams_scheme_types` (
  `scheme_type` CHAR(10) NOT NULL ,
  `scheme_name` CHAR(50) NULL ,
  `scheme_description` CHAR(255) NULL ,
  `criteria` CHAR(15) NULL ,
  `crediting_factor` CHAR(30) NULL ,
  PRIMARY KEY (`scheme_type`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`affiliate_scheme_def`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`affiliate_scheme_def` (
  `scheme_id` INT NULL ,
  `slab_id` INT NULL AUTO_INCREMENT ,
  `scheme_type` CHAR(10) NULL ,
  `min` FLOAT NULL ,
  `max` FLOAT NULL ,
  `factor` FLOAT NULL ,
  `prerequisite` CHAR(45) NULL ,
  `prerequisite_count` FLOAT NULL ,
  `expiry_time` DATETIME NULL ,
  `rule_met` TINYINT(1) NULL ,
  `extended_forumla` TINYINT(1) NULL ,
  PRIMARY KEY (`scheme_id`, `slab_id`) ,
  CONSTRAINT `scheme_type`
    FOREIGN KEY (`scheme_type` )
    REFERENCES `zenfox`.`ams_scheme_types` (`scheme_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `scheme_id`
    FOREIGN KEY (`scheme_id` )
    REFERENCES `zenfox`.`affiliate_schemes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `scheme_type` ON `zenfox`.`affiliate_scheme_def` (`scheme_type` ASC) ;

SHOW WARNINGS;
CREATE INDEX `scheme_id` ON `zenfox`.`affiliate_scheme_def` (`scheme_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_scheme_def_scheme_id` ON `zenfox`.`affiliate_scheme_def` (`scheme_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`affiliate_frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`affiliate_frontend` (
  `id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `affiliate_allowed_frontend_ids` CHAR(255) NULL ,
  `allowed_frontend_ids` CHAR(255) NULL ,
  `default_affiliate_scheme_id` INT NULL ,
  `timezone` CHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`affiliate`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`affiliate` (
  `affiliate_id` INT(10) NOT NULL AUTO_INCREMENT ,
  `alias` CHAR(25) NULL ,
  `passwd` CHAR(25) NULL ,
  `firstname` CHAR(50) NULL ,
  `lastname` CHAR(50) NULL ,
  `company` CHAR(100) NULL ,
  `address` CHAR(200) NULL ,
  `city` CHAR(50) NULL ,
  `state` CHAR(50) NULL ,
  `country` CHAR(50) NULL ,
  `zip` CHAR(11) NULL ,
  `email` CHAR(255) NULL ,
  `phone` CHAR(20) NULL ,
  `payment_type` VARCHAR(45) NULL ,
  `master_id` INT(10) NULL ,
  `created` DATETIME NULL ,
  `enabled` TINYINT(1) NULL ,
  `language` CHAR(7) NULL ,
  `affiliate_frontend_id` INT NULL ,
  `balance` FLOAT NULL DEFAULT 0.00 ,
  `master_contrib` FLOAT NULL DEFAULT 0.00 ,
  `master_deduction` FLOAT NULL DEFAULT 0.00 ,
  `buddy_balance` FLOAT NULL DEFAULT 0.00 ,
  `timezone` CHAR(45) NULL ,
  PRIMARY KEY (`affiliate_id`) ,
  CONSTRAINT `affiliate_language`
    FOREIGN KEY (`language` )
    REFERENCES `zenfox`.`language` (`locale` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `affiliate_affiliate_frontend_id`
    FOREIGN KEY (`affiliate_frontend_id` )
    REFERENCES `zenfox`.`affiliate_frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `master_id`
    FOREIGN KEY (`master_id` )
    REFERENCES `zenfox`.`affiliate` (`affiliate_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `affiliate_language` ON `zenfox`.`affiliate` (`language` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_affiliate_frontend_id` ON `zenfox`.`affiliate` (`affiliate_frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `master_id` ON `zenfox`.`affiliate` (`master_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`csr`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`csr` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `alias` CHAR(45) NULL ,
  `passwd` CHAR(45) NULL ,
  `name` CHAR(55) NULL ,
  `enabled` ENUM('ENABLED', 'DISABLED') ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_access_ips`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_access_ips` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ip_address` CHAR(40) NULL ,
  `description` CHAR(255) NULL ,
  `enabled` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_group` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(50) NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_group_frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_group_frontend` (
  `gms_group_id` INT NULL ,
  `frontend_id` INT NULL ,
  PRIMARY KEY (`gms_group_id`, `frontend_id`) ,
  CONSTRAINT `group_id`
    FOREIGN KEY (`gms_group_id` )
    REFERENCES `zenfox`.`gms_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gms_group_frontend_frontend_id`
    FOREIGN KEY (`frontend_id` )
    REFERENCES `zenfox`.`frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `group_id` ON `zenfox`.`gms_group_frontend` (`gms_group_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gms_group_frontend_frontend_id` ON `zenfox`.`gms_group_frontend` (`frontend_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_menu`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_menu` (
  `id` INT NOT NULL ,
  `name` CHAR(100) NULL ,
  `description` CHAR(100) NULL ,
  `enabled` enum('ENABLED','DISABLED') DEFAULT 'ENABLED' ,
  `link` enum('LINK','NOLINK') DEFAULT 'NOLINK' ,
  `address` CHAR(255) NULL ,
  `visible` enum('VISIBLE','INVISIBLE') DEFAULT 'INVISIBLE' ,
  PRIMARY KEY (`id`))
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_menu_link`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_menu_link` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `link_id` INT NULL ,
  `parent_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`id` )
    REFERENCES `zenfox`.`gms_menu` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `link_id`
    FOREIGN KEY (`id` )
    REFERENCES `zenfox`.`gms_menu` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `parent_id` ON `zenfox`.`gms_menu_link` (`parent_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `link_id` ON `zenfox`.`gms_menu_link` (`link_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_group_gms_menu`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_group_gms_menu` (
  `gms_group_id` INT NULL ,
  `gms_menu_id` INT NULL ,
  PRIMARY KEY (`gms_group_id`, `gms_menu_id`) ,
  CONSTRAINT `gms_group_gms_menu_group_id`
    FOREIGN KEY (`gms_group_id` )
    REFERENCES `zenfox`.`gms_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `menu_id`
    FOREIGN KEY (`gms_menu_id` )
    REFERENCES `zenfox`.`gms_menu` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `gms_group_gms_menu_group_id` ON `zenfox`.`gms_group_gms_menu` (`gms_group_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `menu_id` ON `zenfox`.`gms_group_gms_menu` (`gms_menu_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`csr_gms_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`csr_gms_group` (
  `csr_id` INT NULL ,
  `gms_group_id` INT NULL ,
  PRIMARY KEY (`csr_id`, `gms_group_id`) ,
  CONSTRAINT `csr_gms_group_csr_id`
    FOREIGN KEY (`csr_id` )
    REFERENCES `zenfox`.`csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `csr_gms_group_group_id`
    FOREIGN KEY (`gms_group_id` )
    REFERENCES `zenfox`.`gms_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `csr_gms_group_csr_id` ON `zenfox`.`csr_gms_group` (`csr_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `csr_gms_group_group_id` ON `zenfox`.`csr_gms_group` (`gms_group_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gmslinks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gmslinks` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `address` CHAR(255) NULL ,
  `visible` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`group_gmslinks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`group_gmslinks` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `group_id` INT NULL ,
  `link_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `group_gmslinks_group_id`
    FOREIGN KEY (`group_id` )
    REFERENCES `zenfox`.`gms_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `group_gmslinks_link_id`
    FOREIGN KEY (`link_id` )
    REFERENCES `zenfox`.`gmslinks` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `group_gmslinks_group_id` ON `zenfox`.`group_gmslinks` (`group_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `group_gmslinks_link_id` ON `zenfox`.`group_gmslinks` (`link_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_group_permissions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_group_permissions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `gms_group_id` INT NULL ,
  `permission` CHAR(100) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `gsm_group_permissions_group_id`
    FOREIGN KEY (`gms_group_id` )
    REFERENCES `zenfox`.`gms_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `gsm_group_permissions_group_id` ON `zenfox`.`gms_group_permissions` (`gms_group_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gms_log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gms_log` (
  `id` INT NOT NULL ,
  `csr_id` INT NULL ,
  `action` CHAR(255) NULL ,
  `action_time` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `gms_log_csr_id`
    FOREIGN KEY (`csr_id` )
    REFERENCES `zenfox`.`csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `gms_log_csr_id` ON `zenfox`.`gms_log` (`csr_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`data_mask`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`data_mask` (
  `id` INT NOT NULL ,
  `mask_name` CHAR(255) NULL ,
  `mask_filed` CHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`data_mask_gms_group`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`data_mask_gms_group` (
  `gms_group_id` INT NULL ,
  `data_mask_id` INT NULL ,
  PRIMARY KEY (`gms_group_id`, `data_mask_id`) ,
  CONSTRAINT `data_mask_gms_group_group_id`
    FOREIGN KEY (`gms_group_id` )
    REFERENCES `zenfox`.`gms_group` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `mask_id`
    FOREIGN KEY (`data_mask_id` )
    REFERENCES `zenfox`.`data_mask` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `data_mask_gms_group_group_id` ON `zenfox`.`data_mask_gms_group` (`gms_group_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `mask_id` ON `zenfox`.`data_mask_gms_group` (`data_mask_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`affiliate_tracker`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`affiliate_tracker` (
  `tracker_id` INT NOT NULL AUTO_INCREMENT ,
  `tracker_type` TINYINT(1) NULL ,
  `tracker_name` CHAR(45) NULL ,
  `affiliate_id` INT(10) NULL ,
  `scheme_id` INT NULL ,
  PRIMARY KEY (`tracker_id`) ,
  CONSTRAINT `affiliate_tracker_scheme_id`
    FOREIGN KEY (`scheme_id` )
    REFERENCES `zenfox`.`affiliate_schemes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_tracker_scheme_id2`
    FOREIGN KEY (`scheme_id` )
    REFERENCES `zenfox`.`affiliate_scheme_def` (`scheme_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `affiliate_tracker_scheme_id` ON `zenfox`.`affiliate_tracker` (`scheme_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_tracker_scheme_id2` ON `zenfox`.`affiliate_tracker` (`scheme_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`tracker_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`tracker_details` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tracker_id` INT NULL ,
  `variable_name` CHAR(20) NULL ,
  `varaibale_value` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `tracker_id`
    FOREIGN KEY (`tracker_id` )
    REFERENCES `zenfox`.`affiliate_tracker` (`tracker_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `tracker_id` ON `zenfox`.`tracker_details` (`tracker_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`affiliate_transactions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`affiliate_transactions` (
  `audit_id` INT NOT NULL AUTO_INCREMENT ,
  `prev_audit_id` INT NULL ,
  `player_audit_id` INT NULL ,
  `source_id` INT NULL ,
  `slave_id` INT NULL ,
  `trans_type` INT NULL ,
  `amount` FLOAT NULL ,
  `amount_type` ENUM('REAL','BONUS','BOTH') NULL ,
  `commission_amount` FLOAT NULL ,
  `transaction_currency` CHAR(3) NULL ,
  `affiliate_base_currency` CHAR(3) NULL ,
  `base_currency_amount` FLOAT NULL ,
  `conversion_rate` FLOAT NULL ,
  `affiliate_id` INT NULL ,
  `player_id` INT NULL ,
  `tracker_id` INT NULL ,
  `scheme_id` INT NULL ,
  `slab_id` INT NULL ,
  `master_contribution` FLOAT NULL ,
  `master_level` INT NULL ,
  `master_id` INT NULL ,
  `trans_start_time` DATETIME NULL ,
  `trans_end_time` DATETIME NULL ,
  `affiliate_balance` FLOAT NULL ,
  `tracker_earnings` FLOAT NULL ,
  `processed` TINYINT(1) NULL ,
  `error` TINYINT(1) NULL ,
  `notes` CHAR(255) NULL ,
  `player_frontend_id` INT NULL ,
  `affiliate_frontend_id` INT NULL ,
  PRIMARY KEY (`audit_id`) ,
  CONSTRAINT `source_id`
    FOREIGN KEY (`source_id` )
    REFERENCES `zenfox`.`player_transactions` (`source_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `scheme_def`
    FOREIGN KEY (`scheme_id` , `slab_id` )
    REFERENCES `zenfox`.`affiliate_scheme_def` (`scheme_id` , `slab_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_transactions_master_id`
    FOREIGN KEY (`master_id` )
    REFERENCES `zenfox`.`affiliate` (`master_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `slave_id`
    FOREIGN KEY (`slave_id` )
    REFERENCES `zenfox`.`affiliate` (`affiliate_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_id`
    FOREIGN KEY (`affiliate_id` )
    REFERENCES `zenfox`.`affiliate` (`affiliate_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `affiliate_transactions_affiliate_frontend_id`
    FOREIGN KEY (`affiliate_frontend_id` )
    REFERENCES `zenfox`.`affiliate_frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `player_frontend_id`
    FOREIGN KEY (`player_frontend_id` )
    REFERENCES `zenfox`.`frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ptr_trans_id`
    FOREIGN KEY (`player_id` , `player_audit_id` )
    REFERENCES `zenfox`.`audit_report` (`player_id` , `audit_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `source_id` ON `zenfox`.`affiliate_transactions` (`source_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `scheme_def` ON `zenfox`.`affiliate_transactions` (`scheme_id` ASC, `slab_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_transactions_master_id` ON `zenfox`.`affiliate_transactions` (`master_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `slave_id` ON `zenfox`.`affiliate_transactions` (`slave_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_id` ON `zenfox`.`affiliate_transactions` (`affiliate_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `affiliate_transactions_affiliate_frontend_id` ON `zenfox`.`affiliate_transactions` (`affiliate_frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `player_frontend_id` ON `zenfox`.`affiliate_transactions` (`player_frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ptr_trans_id` ON `zenfox`.`affiliate_transactions` (`player_id` ASC, `player_audit_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`pjp_audit`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`pjp_audit` (
  `id` INT NOT NULL ,
  `audit_id` INT NULL ,
  `source_id` INT NULL ,
  `pjp_id` INT NULL ,
  `running_machine_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `real_contrib` FLOAT NULL ,
  `bb_contrib` FLOAT NULL ,
  `gen_random` FLOAT NULL ,
  `gamelog_id` INT NULL ,
  `gamelog_session_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `game_group`
    FOREIGN KEY (`game_flavour` , `running_machine_id` )
    REFERENCES `zenfox`.`game_gamegroups` (`game_flavour` , `running_machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `game_group` ON `zenfox`.`pjp_audit` (`game_flavour` ASC, `running_machine_id` ASC) ;

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
-- Table `zenfox`.`country`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`country` (
  `id` INT NOT NULL ,
  `country` CHAR(100) NULL ,
  `country_code` CHAR(2) NULL ,
  `numcode` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE UNIQUE INDEX `country_code` ON `zenfox`.`country` (`country_code` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `numcode` ON `zenfox`.`country` (`numcode` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`language` (
  `id` INT NOT NULL ,
  `language` CHAR(45) NULL ,
  `locale` CHAR(7) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE UNIQUE INDEX `locale` ON `zenfox`.`language` (`locale` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`currency`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`currency` (
  `currency_code` CHAR(3) NOT NULL ,
  `currency` CHAR(45) NULL ,
  `symbol` CHAR(5) NULL ,
  `currency_description` CHAR(255) NULL ,
  PRIMARY KEY (`currency_code`) )
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE UNIQUE INDEX `currency_code` ON `zenfox`.`currency` (`currency_code` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bonus_schemes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bonus_schemes` (
  `scheme_id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`scheme_id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`no_payment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`no_payment` (
  `player_id` INT(11) NOT NULL ,
  `payment_type_not_allowed` INT(4) NOT NULL ,
  CONSTRAINT `no_payment_player_id`
    FOREIGN KEY (`player_id` )
    REFERENCES `zenfox`.`account` (`player_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
CREATE INDEX `player_id_index` ON `zenfox`.`no_payment` (`player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `no_payment_player_id` ON `zenfox`.`no_payment` (`player_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`country_language`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`country_language` (
  `id` INT NOT NULL ,
  `country_code` CHAR(2) NULL ,
  `locale` CHAR(7) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `country_code`
    FOREIGN KEY (`country_code` )
    REFERENCES `zenfox`.`country` (`country_code` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `locale`
    FOREIGN KEY (`locale` )
    REFERENCES `zenfox`.`language` (`locale` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `country_code` ON `zenfox`.`country_language` (`country_code` ASC) ;

SHOW WARNINGS;
CREATE INDEX `locale` ON `zenfox`.`country_language` (`locale` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`country_currency`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`country_currency` (
  `id` INT NOT NULL ,
  `country_code` CHAR(2) NULL ,
  `currency_code` CHAR(3) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `country_currency_country_code`
    FOREIGN KEY (`country_code` )
    REFERENCES `zenfox`.`country` (`country_code` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `currency_code`
    FOREIGN KEY (`currency_code` )
    REFERENCES `zenfox`.`currency` (`currency_code` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `country_currency_country_code` ON `zenfox`.`country_currency` (`country_code` ASC) ;

SHOW WARNINGS;
CREATE INDEX `currency_code` ON `zenfox`.`country_currency` (`currency_code` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`flavours`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`flavours` (
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
CREATE UNIQUE INDEX `flavour_code` ON `zenfox`.`flavours` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`slots`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`slots` (
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
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `game_flavour` ON `zenfox`.`slots` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`running_slots`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`running_slots` (
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
    REFERENCES `zenfox`.`slots` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `currency`
    FOREIGN KEY (`default_currency` )
    REFERENCES `zenfox`.`currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `created_by`
    FOREIGN KEY (`created_by` )
    REFERENCES `zenfox`.`csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `last_updated_by`
    FOREIGN KEY (`last_updated_by` )
    REFERENCES `zenfox`.`csr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `zenfox`.`slots` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `machine_id` ON `zenfox`.`running_slots` (`machine_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `currency` ON `zenfox`.`running_slots` (`default_currency` ASC) ;

SHOW WARNINGS;
CREATE INDEX `created_by` ON `zenfox`.`running_slots` (`created_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `last_updated_by` ON `zenfox`.`running_slots` (`last_updated_by` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_flavour` ON `zenfox`.`running_slots` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`frontend` (
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
    REFERENCES `zenfox`.`affiliate_frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `default_bonus_scheme_id`
    FOREIGN KEY (`default_bonus_scheme_id` )
    REFERENCES `zenfox`.`bonus_schemes` (`scheme_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `default_currency`
    FOREIGN KEY (`default_currency` )
    REFERENCES `zenfox`.`currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `affiliate_frontend_id` ON `zenfox`.`frontend` (`affiliate_frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `default_bonus_scheme_id` ON `zenfox`.`frontend` (`default_bonus_scheme_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `default_currency` ON `zenfox`.`frontend` (`default_currency` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gamegroups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gamegroups` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `enabled` ENUM('ENABLED', 'DISABLED') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `name` ON `zenfox`.`gamegroups` (`name` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`gamegroup_frontend`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`gamegroup_frontend` (
  `id` INT NOT NULL ,
  `frontend_id` INT(3) NULL ,
  `gamegroup_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `frontend_id`
    FOREIGN KEY (`frontend_id` )
    REFERENCES `zenfox`.`frontend` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamegroup_id`
    FOREIGN KEY (`gamegroup_id` )
    REFERENCES `zenfox`.`gamegroups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `frontend_id` ON `zenfox`.`gamegroup_frontend` (`frontend_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamegroup_id` ON `zenfox`.`gamegroup_frontend` (`gamegroup_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`pjp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`pjp` (
  `id` INT NOT NULL AUTO_INCREMENT,
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
    REFERENCES `zenfox`.`currency` (`currency_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `pjp_currency` ON `zenfox`.`pjp` (`currency` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`machines_pjp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`machines_pjp` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pjp_id` INT NULL ,
  `running_machine_id` INT NOT NULL ,
  `enabled` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `slots_machine_id`
    FOREIGN KEY (`running_machine_id` )
    REFERENCES `zenfox`.`running_slots` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `slots_machine_id` ON `zenfox`.`machines_pjp` (`running_machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`pjp_machines`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`pjp_machines` (
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
    REFERENCES `zenfox`.`running_slots` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pjp_id`
    FOREIGN KEY (`pjp_id` )
    REFERENCES `zenfox`.`pjp` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `game_id` ON `zenfox`.`pjp_machines` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `pjp_id` ON `zenfox`.`pjp_machines` (`pjp_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_flavour` ON `zenfox`.`pjp_machines` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`slots_feature`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`slots_feature` (
  `id` INT NOT NULL AUTO_INCREMENT ,
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
    REFERENCES `zenfox`.`slots` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `slots_featured_machine_id` ON `zenfox`.`slots_feature` (`machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`slots_bonus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`slots_bonus` (
  `id` INT NOT NULL ,
  `bonus_spin_type` TINYINT(1) NULL ,
  `machine_id` INT NULL ,
  `spins_awarded` INT NULL ,
  `combination` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `slots_bonus_machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `zenfox`.`slots` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `slots_bonus_machine_id` ON `zenfox`.`slots_bonus` (`machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`ticket_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`ticket_type` (
  `id` INT NOT NULL ,
  `ticket_type_name` CHAR(255) NULL ,
  `ticket_type_description` CHAR(255) NULL ,
  `enabled` TINYINT(1) NULL ,
  `user_type` ENUM('AFFILIATE', 'PLAYER') NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;


----------------
	Table `zenfox`.`leader_board_data`
----------------
CREATE TABLE `leader_board_data` (
  `leader_board_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL DEFAULT '0',
  `variable_1` float DEFAULT NULL,
  `variable_2` float DEFAULT NULL,
  `variable_3` float DEFAULT NULL,
  PRIMARY KEY (`leader_board_id`,`player_id`)
)
ENGINE = MyISAM;

SHOW WARNINGS;



----------------
	Table `zenfox`.`leader_board_teams`
----------------
 CREATE TABLE `leader_board_teams` (
  `team_id` int(11) NOT NULL,
  `leader_board_id` int(11) NOT NULL,
  `name` char(45) DEFAULT NULL,
  `url` char(255) DEFAULT NULL,
  PRIMARY KEY (`leader_board_id`,`team_id`)
) ENGINE=InnoDB;

SHOW WARNINGS;


----------------
	Table `zenfox`.`leader_board_config`
----------------
 CREATE TABLE `leader_board_config` (
  `leader_board_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL,
  `description` char(255) DEFAULT NULL,
  `game_type` enum('RUMMY','BINGO','SLOTS','ROULETTE','KENO') DEFAULT NULL,
  `flavour` char(255) DEFAULT NULL,
  `amount_type` enum('REAL','BONUS','BOTH','FREE','ALL') DEFAULT NULL,
  `status` enum('CREATED','STARTED','COMPLETED','CANCELED') DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `frontend_id` char(255) DEFAULT NULL,
  `variable_data` char(255) DEFAULT NULL,
  `last_calculated_time` datetime DEFAULT NULL,
  `no_of_teams` int(11) DEFAULT NULL,
  PRIMARY KEY (`leader_board_id`)
) ENGINE=InnoDB;

SHOW WARNINGS;



-- -----------------------------------------------------
-- Table `zenfox`.`roulette`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`roulette` (
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
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `roulette_game_flavour` ON `zenfox`.`roulette` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`running_roulette`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`running_roulette` (
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
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `running_roulette_machine_id`
    FOREIGN KEY (`machine_id` )
    REFERENCES `zenfox`.`roulette` (`machine_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `running_roulette_game_flavour` ON `zenfox`.`running_roulette` (`game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `running_roulette_machine_id` ON `zenfox`.`running_roulette` (`machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_rooms`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_rooms` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(45) NULL ,
  `description` CHAR(255) NULL ,
  `allowed_game_flavours` CHAR(255) NULL ,
  `enabled` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`game_gamegroups`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`game_gamegroups` (
  `id` INT NOT NULL ,
  `running_machine_id` INT NULL ,
  `game_flavour` CHAR(45) NULL ,
  `gamegroup_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `roulette_games`
    FOREIGN KEY (`running_machine_id` , `game_flavour` )
    REFERENCES `zenfox`.`running_roulette` (`id` , `game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `slots_games`
    FOREIGN KEY (`running_machine_id` , `game_flavour` )
    REFERENCES `zenfox`.`running_slots` (`id` , `game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_rooms`
    FOREIGN KEY (`running_machine_id` )
    REFERENCES `zenfox`.`bingo_rooms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `roulette_games` ON `zenfox`.`game_gamegroups` (`running_machine_id` ASC, `game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `slots_games` ON `zenfox`.`game_gamegroups` (`running_machine_id` ASC, `game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `machine_flavours` ON `zenfox`.`game_gamegroups` (`game_flavour` ASC, `running_machine_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bonus_levels`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bonus_levels` (
  `scheme_id` INT NULL ,
  `level_id` INT NULL AUTO_INCREMENT ,
  `level_name` CHAR(45) NULL ,
  `min_points` FLOAT NULL ,
  `max_points` FLOAT NULL ,
  `bonus_percentage` FLOAT NULL ,
  `fixed_bonus` FLOAT NULL ,
  `min_deposit` FLOAT NULL ,
  `min_total_deposit` FLOAT NULL ,
  `reward_times` INT NULL ,
  `description` CHAR(255) NULL ,
  `fixed_real` FLOAT NULL ,
  PRIMARY KEY (`scheme_id`, `level_id`) )
ENGINE = MyISAM
;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`loyalty_factors`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`loyalty_factors` (
  `id` INT NOT NULL ,
  `scheme_id` INT NULL ,
  `level_id` INT NULL ,
  `gamegroup_id` INT NULL ,
  `wager_factor` FLOAT NULL ,
  `loyalty_per_dollar` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `bonus_level`
    FOREIGN KEY (`scheme_id` , `level_id` )
    REFERENCES `zenfox`.`bonus_levels` (`scheme_id` , `level_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `gamegroup_id`
    FOREIGN KEY (`gamegroup_id` )
    REFERENCES `zenfox`.`gamegroups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bonus_level` ON `zenfox`.`loyalty_factors` (`scheme_id` ASC, `level_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamegroup_id` ON `zenfox`.`loyalty_factors` (`gamegroup_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`pattern`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`pattern` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(50) NULL ,
  `description` CHAR(255) NULL ,
  `pattern` CHAR(255) NULL ,
  `no_of_parts` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_gamelog`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_gamelog` (
  `id` INT NOT NULL AUTO_INCREMENT ,
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
    REFERENCES `zenfox`.`pattern` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_gamelog_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `pattern` ON `zenfox`.`bingo_gamelog` (`pattern_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_game_flavour` ON `zenfox`.`bingo_gamelog` (`game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `session_id` ON `zenfox`.`bingo_gamelog` (`session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `gamelog_sessions` ON `zenfox`.`bingo_gamelog` (`id` ASC, `session_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`variable_pot`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`variable_pot` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `variable_game_id` ON `zenfox`.`variable_pot` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `variable_game_id_fk` ON `zenfox`.`variable_pot` (`game_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`fixed_pot`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`fixed_pot` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `game_id` INT NULL ,
  `part_id` INT NULL ,
  `call_number` INT NULL ,
  `real_amount` FLOAT NULL ,
  `bbs_amount` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fixed_game_id_fk`
    FOREIGN KEY (`game_id` )
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `fixed_game_id` ON `zenfox`.`fixed_pot` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `fixed_game_id_fk` ON `zenfox`.`fixed_pot` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `game_id_call` ON `zenfox`.`fixed_pot` (`game_id` ASC, `call_number` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`category` (
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
-- Table `zenfox`.`game_category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`game_category` (
  `game_id` INT NOT NULL ,
  `category_id` INT NOT NULL ,
  PRIMARY KEY (`game_id`, `category_id`) ,
  CONSTRAINT `bingo_game_id`
    FOREIGN KEY (`game_id` )
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `category`
    FOREIGN KEY (`category_id` )
    REFERENCES `zenfox`.`category` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `bingo_game_id` ON `zenfox`.`game_category` (`game_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `category` ON `zenfox`.`game_category` (`category_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_pjp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_pjp` (
  `id` INT NOT NULL AUTO_INCREMENT ,
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
    REFERENCES `zenfox`.`pjp` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `bingo_pjp_id` ON `zenfox`.`bingo_pjp` (`pjp_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_sessions` (
  `id` INT NOT NULL ,
  `name` CHAR(45) NULL ,
  `desciption` CHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_games`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_games` (
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
    REFERENCES `zenfox`.`pattern` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `pattern` ON `zenfox`.`bingo_games` (`pattern_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_game_flavour` ON `zenfox`.`bingo_games` (`game_flavour` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`session_game`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`session_game` (
  `session_id` INT NOT NULL ,
  `game_id` INT NOT NULL ,
  `sequence` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`session_id`, `game_id`, `sequence`) ,
  CONSTRAINT `bingo_session_id`
    FOREIGN KEY (`session_id` )
    REFERENCES `zenfox`.`bingo_sessions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bingo_session_game_id`
    FOREIGN KEY (`game_id` )
    REFERENCES `zenfox`.`bingo_games` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `session_game` ON `zenfox`.`session_game` (`session_id` ASC, `game_id` ASC, `sequence` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_session_id` ON `zenfox`.`session_game` (`session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_session_game_id` ON `zenfox`.`session_game` (`game_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`rooms_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`rooms_session` (
  `room_id` INT NOT NULL ,
  `session_id` INT NULL ,
  `duration` INT NULL ,
  `sequence` INT NULL ,
  `day` INT NULL ,
  PRIMARY KEY (`room_id`, `session_id`, `sequence`) ,
  CONSTRAINT `bingo_room_id`
    FOREIGN KEY (`room_id` )
    REFERENCES `zenfox`.`bingo_rooms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `room_session_id`
    FOREIGN KEY (`session_id` )
    REFERENCES `zenfox`.`bingo_sessions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE UNIQUE INDEX `unique` ON `zenfox`.`rooms_session` (`room_id` ASC, `session_id` ASC, `sequence` ASC) ;

SHOW WARNINGS;
CREATE INDEX `bingo_room_id` ON `zenfox`.`rooms_session` (`room_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `room_session_id` ON `zenfox`.`rooms_session` (`session_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_gamelog_variable`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_gamelog_variable` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_id` ON `zenfox`.`bingo_gamelog_variable` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_gamelog_fixed`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_gamelog_fixed` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_fixed_id` ON `zenfox`.`bingo_gamelog_fixed` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`ticket_sales`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`ticket_sales` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ticket_sales_audit_id`
    FOREIGN KEY (`player_id` , `audit_id` )
    REFERENCES `zenfox`.`audit_report` (`player_id` , `audit_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `ticket_sales_bingo_gamelog_id` ON `zenfox`.`ticket_sales` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `game_player` ON `zenfox`.`ticket_sales` (`bingo_gamelog_id` ASC, `player_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `ticket_sales_audit_id` ON `zenfox`.`ticket_sales` (`player_id` ASC, `audit_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_winners`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_winners` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_winners_log_id` ON `zenfox`.`bingo_winners` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`bingo_pjp_log`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`bingo_pjp_log` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `pjp_log_bingo_gamelog` ON `zenfox`.`bingo_pjp_log` (`bingo_gamelog_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`pjp_winners`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`pjp_winners` (
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
    REFERENCES `zenfox`.`bingo_gamelog` (`id` , `session_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `slots_gamelog_id`
    FOREIGN KEY (`player_id` , `session_id` , `gamelog_id` )
    REFERENCES `zenfox`.`gamelog_slots` (`player_id` , `session_id` , `log_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pjp_winner_game_flavour`
    FOREIGN KEY (`game_flavour` )
    REFERENCES `zenfox`.`flavours` (`game_flavour` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `pjp_winners_pjp_id`
    FOREIGN KEY (`pjp_id` )
    REFERENCES `zenfox`.`pjp` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM
;

SHOW WARNINGS;
CREATE INDEX `bingo_gamelog_id` ON `zenfox`.`pjp_winners` (`gamelog_id` ASC, `session_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `slots_gamelog_id` ON `zenfox`.`pjp_winners` (`player_id` ASC, `session_id` ASC, `gamelog_id` ASC) ;

SHOW WARNINGS;
CREATE INDEX `pjp_winner_game_flavour` ON `zenfox`.`pjp_winners` (`game_flavour` ASC) ;

SHOW WARNINGS;
CREATE INDEX `pjp_winners_pjp_id` ON `zenfox`.`pjp_winners` (`pjp_id` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`resources`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`resources` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(255) NULL ,
  `resource_type` ENUM('REQUEST','GAME') NULL ,
  `parent_id` INT NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`parent_id` )
    REFERENCES `zenfox`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `parent_id` ON `zenfox`.`resources` (`parent_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `name` ON `zenfox`.`resources` (`name` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` CHAR(255) NULL ,
  `role_type` ENUM('VISITOR', 'PLAYER', 'AFFILIATE', 'CSR') NULL ,
  `parent_id` INT NULL ,
  `description` CHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `parent_id`
    FOREIGN KEY (`parent_id` )
    REFERENCES `zenfox`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `parent_id` ON `zenfox`.`roles` (`parent_id` ASC) ;

SHOW WARNINGS;
CREATE UNIQUE INDEX `role` ON `zenfox`.`roles` (`name` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`privileges`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`privileges` (
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
    REFERENCES `zenfox`.`resources` (`id` , `name` , `resource_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `roles`
    FOREIGN KEY (`role_id` , `role_name` , `role_type` )
    REFERENCES `zenfox`.`roles` (`id` , `name` , `role_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = MyISAM;

SHOW WARNINGS;
CREATE INDEX `resources` ON `zenfox`.`privileges` (`resource_id` ASC, `resource_name` ASC, `resource_type` ASC) ;

SHOW WARNINGS;
CREATE INDEX `roles` ON `zenfox`.`privileges` (`role_id` ASC, `role_name` ASC, `role_type` ASC) ;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `zenfox`.`wagering_rules`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `zenfox`.`wagering_rules` (
  `id` INT NULL AUTO_INCREMENT ,
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
  `ager_met_amount` FLOAT NOT NULL ,
  `amount_type` ENUM('REAL', 'BONUS', 'BOTH') NOT NULL ,
  `audit_id` INT NULL ,
  `source_id` INT NULL ,
  PRIMARY KEY (`player_id`, `id`) )
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

-- -----------------------------------------------------
-- Table `zenfox`.`email`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS email(
`id` INT NOT NULL AUTO_INCREMENT,
`template_name` ENUM('Forgot_Password','Confirmation','Notification') NOT NULL,
`category` CHAR(45) NOT NULL,
`subject` CHAR(255) NOT NULL,
`body` TEXT,
PRIMARY KEY (`id`,`template_name`, `category`) )
ENGINE = MyISAM
;

-- -----------------------------------------------------
-- Table `zenfox`.`tag`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS tag(
`id` INT NOT NULL AUTO_INCREMENT,
`name` char(45) NOT NULL,
`query` char(255) NOT NULL,
PRIMARY KEY (`id`,`name`) )
ENGINE = MyISAM
;

-- -----------------------------------------------------
-- Table `zenfox`.`list`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS list(
`id` INT NOT NULL AUTO_INCREMENT,
`name` CHAR(45) NOT NULL,
`function` TEXT,
`language` CHAR(20),
PRIMARY KEY(`id`))
ENGINE = MyISAM
;

CREATE UNIQUE INDEX `name` ON `list` (`name` ASC);

-- -----------------------------------------------------
-- Table `zenfox`.`mail_log`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS mail_log(
`id` INT NOT NULL AUTO_INCREMENT,
`list_id` INT NOT NULL,
`template_id` INT NOT NULL,
`language` CHAR(20),
`frontend_id` INT,
`status` ENUM('PROCESSED','UNPROCESSED') DEFAULT 'UNPROCESSED',
`error` CHAR(255),
PRIMARY KEY(`id`,`list_id`,`template_id`))
ENGINE = MyISAM
;

-- -----------------------------------------------------
-- Table `zenfox`.`partner_frontends`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `zenfox`.`partner_frontends` (
  `partner_frontend_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(45) NULL ,
  `allowed_frontend_ids` VARCHAR(45) NULL ,
  `default_currency` VARCHAR(3) NULL ,
  `timezone` VARCHAR(45) NULL ,
  `url` VARCHAR(100) NULL ,
  PRIMARY KEY (`partner_frontend_id`) )
ENGINE = MyISAM;

CREATE  TABLE IF NOT EXISTS `zenfox`.`partner_groups` (
  `partner_group_id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `allowed_frontend_ids` VARCHAR(45) NULL ,
  `description` VARCHAR(100) NULL ,
  PRIMARY KEY (`partner_group_id`) )
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `zenfox`.`partner_privileges`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `zenfox`.`partner_privileges` (
  `partner_privilege_id` INT NOT NULL AUTO_INCREMENT ,
  `partner_resource_id` INT NOT NULL ,
  `partner_group_id` INT NOT NULL ,
  PRIMARY KEY (`partner_resource_id`, `partner_group_id`) ,
  UNIQUE INDEX `partner_privilege_id_UNIQUE` (`partner_privilege_id` ASC) )
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `zenfox`.`partner_resources`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `zenfox`.`partner_resources` (
  `partner_resource_id` INT NOT NULL AUTO_INCREMENT ,
  `resource_name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`partner_resource_id`) ,
  UNIQUE INDEX `resource_name_UNIQUE` (`resource_name` ASC) )
ENGINE = MyISAM;

-- -----------------------------------------------------
-- Table `zenfox`.`partners`
-- -----------------------------------------------------

CREATE  TABLE IF NOT EXISTS `zenfox`.`partners` (
  `partner_id` INT NOT NULL AUTO_INCREMENT ,
  `alias` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `partner_frontend_id` INT(11) NOT NULL ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `address` VARCHAR(255) NULL ,
  `city` VARCHAR(45) NULL ,
  `state` VARCHAR(100) NULL ,
  `pin` VARCHAR(15) NULL ,
  `country_id` INT(11) NULL ,
  `phone_no` VARCHAR(15) NULL ,
  `created` DATETIME NULL ,
  `language` VARCHAR(10) NULL ,
  `allowed_group_ids` VARCHAR(45) NULL ,
  PRIMARY KEY (`partner_id`) ,
  UNIQUE INDEX `alias_UNIQUE` (`alias` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = MyISAM;

CREATE  TABLE IF NOT EXISTS `zenfox`.`promotion_schedule` (
  `promotion_schedule_id` INT NOT NULL AUTO_INCREMENT ,
  `action` VARCHAR(45) NULL ,
  `condition` VARCHAR(255) NULL ,
  `content` TEXT NULL ,
  `start_time` DATETIME NULL ,
  `end_time` DATETIME NULL ,
  `frontend_id` INT NULL ,
  PRIMARY KEY (`promotion_schedule_id`) )
ENGINE = MyISAM;

CREATE  TABLE IF NOT EXISTS `zenfox`.`mobile_bonus` (
  `mobile_bonus_id` INT NOT NULL AUTO_INCREMENT ,
  `level_id` INT NOT NULL ,
  `gamegroup_id` INT NOT NULL ,
  `buddy_bonus` DOUBLE NULL ,
  `max_buddy_bonus` DOUBLE NULL ,
  `base_bonus` DOUBLE NULL ,
  `level_multiplier` INT NULL ,
  `max_bonus` DOUBLE NULL ,
  UNIQUE INDEX `mobile_bonus_id_UNIQUE` (`mobile_bonus_id` ASC) ,
  PRIMARY KEY (`level_id`, `gamegroup_id`) )
ENGINE = MyISAM;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `zenfox`.`flavours`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;
INSERT INTO `flavours` (`id`, `name`, `description`, `game_flavour`, `main_table`, `running_table`, `game_log_table`, `pjp_link`) VALUES (1, '2', 'US', 'US Roulette', 'RU_US', NULL, NULL, NULL);
INSERT INTO `flavours` (`id`, `name`, `description`, `game_flavour`, `main_table`, `running_table`, `game_log_table`, `pjp_link`) VALUES (2, '2', 'EU', 'EU Roulette', 'RU_EU', NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `zenfox`.`gamegroups`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;
INSERT INTO `gamegroups` (`id`, `name`, `description`, `enabled`) VALUES (1, 'bingo', 'Default group for bingo games. (Default can be changed)', NULL);
INSERT INTO `gamegroups` (`id`, `name`, `description`, `enabled`) VALUES (2, 'slots', 'Default group for all slots games (Default can be changed)', NULL);
INSERT INTO `gamegroups` (`id`, `name`, `description`, `enabled`) VALUES (3, 'roulette', 'Default group for all roulette games (Default can be changed)', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `zenfox`.`pjp`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;
INSERT INTO `pjp` (`id`, `pjp_name`, `description`, `currency`, `bbs_enabled`, `bbs_pjp`, `real_pjp`, `random_number`, `seed`, `min_amount_bbs`, `min_amount_real`, `max_amount_bbs`, `max_amount_real`, `reset_close`, `closed`, `allowed_frontends`) VALUES (0, 'TestPJP', 'Test', 'EUR', 1, 0, 0, 1234567, 10000000, 0, 0, 10000, 10000, '1', 0, '1,2,3,4,5');

COMMIT;

-- -----------------------------------------------------
-- Data for table `zenfox`.`pjp_machines`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;
INSERT INTO `pjp_machines` (`id`, `pjp_id`, `game_flavour`, `game_id`, `percent_real`, `percent_bbs`, `min_bet_real`, `min_bet_bbs`, `max_bet_real`, `max_bet_bbs`) VALUES (0, 1, 'RU', 'EU', 1, 5, 5, 0, 0, 100);

COMMIT;

-- -----------------------------------------------------
-- Data for table `zenfox`.`category`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
-- USE`zenfox`;
INSERT INTO `category` (`id`, `name`, `description`, `pre_buy_enabled`, `visible`) VALUES (1, 'ALL', 'All games fall under this category', 1, 0);

COMMIT;
