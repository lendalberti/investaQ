SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `iq2` ;
CREATE SCHEMA IF NOT EXISTS `iq2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `iq2` ;

-- -----------------------------------------------------
-- Table `iq2`.`us_states`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`us_states` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`us_states` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `long_name` VARCHAR(45) NULL ,
  `short_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `short_name_UNIQUE` (`long_name` ASC) ,
  UNIQUE INDEX `long_name_UNIQUE` (`short_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`countries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`countries` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`countries` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `short_name` VARCHAR(45) NULL ,
  `long_name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`short_name` ASC) ,
  UNIQUE INDEX `long_name_UNIQUE` (`long_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`customer_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`customer_types` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`customer_types` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`regions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`regions` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`regions` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`tiers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`tiers` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`tiers` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`users` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `group_id` INT NULL ,
  `username` VARCHAR(45) NULL ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `title` VARCHAR(45) NULL ,
  `phone` VARCHAR(45) NULL ,
  `fax` VARCHAR(45) NULL ,
  `sig` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`territories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`territories` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`territories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`customers` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`customers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `address1` VARCHAR(45) NOT NULL ,
  `address2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NOT NULL ,
  `state_id` INT NULL ,
  `country_id` INT NOT NULL ,
  `zip` VARCHAR(45) NULL ,
  `region_id` INT NOT NULL ,
  `customer_type_id` INT NOT NULL ,
  `territory_id` INT NOT NULL ,
  `vertical_market` VARCHAR(45) NULL ,
  `parent_id` INT NULL ,
  `company_link` VARCHAR(45) NULL ,
  `syspro_account_code` VARCHAR(45) NULL ,
  `xmas_list` INT NULL ,
  `candy_list` INT NULL ,
  `strategic` INT NULL ,
  `tier_id` INT NULL ,
  `inside_salesperson_id` INT NULL ,
  `outside_salesperson_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_customers_1_idx` (`state_id` ASC) ,
  INDEX `fk_customers_2_idx` (`country_id` ASC) ,
  INDEX `fk_customers_3_idx` (`customer_type_id` ASC) ,
  INDEX `fk_customers_4_idx` (`region_id` ASC) ,
  INDEX `fk_customers_5_idx` (`tier_id` ASC) ,
  INDEX `fk_customers_6_idx` (`parent_id` ASC) ,
  INDEX `fk_customers_7_idx` (`inside_salesperson_id` ASC) ,
  INDEX `fk_customers_8_idx` (`outside_salesperson_id` ASC) ,
  INDEX `fk_customers_9_idx` (`territory_id` ASC) ,
  CONSTRAINT `fk_customers_1`
    FOREIGN KEY (`state_id` )
    REFERENCES `iq2`.`us_states` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_2`
    FOREIGN KEY (`country_id` )
    REFERENCES `iq2`.`countries` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_3`
    FOREIGN KEY (`customer_type_id` )
    REFERENCES `iq2`.`customer_types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_4`
    FOREIGN KEY (`region_id` )
    REFERENCES `iq2`.`regions` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_5`
    FOREIGN KEY (`tier_id` )
    REFERENCES `iq2`.`tiers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_6`
    FOREIGN KEY (`parent_id` )
    REFERENCES `iq2`.`customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_7`
    FOREIGN KEY (`inside_salesperson_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_8`
    FOREIGN KEY (`outside_salesperson_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_9`
    FOREIGN KEY (`territory_id` )
    REFERENCES `iq2`.`territories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`status` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`status` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`lost_reasons`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`lost_reasons` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`lost_reasons` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`no_bid_reasons`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`no_bid_reasons` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`no_bid_reasons` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`quote_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`quote_types` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`quote_types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`levels`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`levels` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`levels` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`sources`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`sources` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`sources` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`die_manufacturers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`die_manufacturers` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`die_manufacturers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `short_name` VARCHAR(45) NOT NULL ,
  `long_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`package_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`package_types` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`package_types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`process_flow`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`process_flow` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`process_flow` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`testing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`testing` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`testing` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`priority`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`priority` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`priority` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`lead_quality`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`lead_quality` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`lead_quality` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`quotes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`quotes` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`quotes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quote_no` VARCHAR(45) NOT NULL ,
  `quote_type_id` INT NOT NULL ,
  `status_id` INT NOT NULL ,
  `owner_id` INT NOT NULL ,
  `customer_id` INT NOT NULL ,
  `contact_id` INT NOT NULL ,
  `created_date` TIMESTAMP NOT NULL DEFAULT NOW() ,
  `updated_date` DATETIME NOT NULL ,
  `expiration_date` DATETIME NOT NULL ,
  `level_id` INT NOT NULL DEFAULT 1 ,
  `source_id` INT NOT NULL ,
  `lead_quality_id` INT NULL ,
  `additional_notes` TEXT NULL ,
  `terms_conditions` TEXT NULL ,
  `customer_acknowledgment` TEXT NULL ,
  `risl` TEXT NULL ,
  `manufacturing_lead_time` TEXT NULL ,
  `lost_reason_id` INT NULL ,
  `no_bid_reason_id` INT NULL ,
  `ready_to_order` INT NULL ,
  `requested_part_number` VARCHAR(45) NULL ,
  `generic_part_number` VARCHAR(45) NULL ,
  `quantity1` INT NULL ,
  `quantity2` INT NULL ,
  `quantity3` INT NULL ,
  `die_manufacturer_id` INT NULL ,
  `package_type_id` INT NULL ,
  `lead_count` INT NULL ,
  `process_flow_id` INT NULL ,
  `testing_id` INT NULL ,
  `priority_id` INT NULL ,
  `temp_low` VARCHAR(45) NULL ,
  `temp_high` VARCHAR(45) NULL ,
  `ncnr` TINYINT(1) NULL ,
  `itar` TINYINT(1) NULL ,
  `have_die` TINYINT(1) NULL ,
  `spa` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_quotes_2_idx` (`customer_id` ASC) ,
  INDEX `fk_quotes_3_idx` (`owner_id` ASC) ,
  INDEX `fk_quotes_1_idx` (`status_id` ASC) ,
  INDEX `fk_quotes_4_idx` (`lost_reason_id` ASC) ,
  INDEX `fk_quotes_5_idx` (`no_bid_reason_id` ASC) ,
  INDEX `fk_quotes_6_idx` (`quote_type_id` ASC) ,
  UNIQUE INDEX `quote_no_UNIQUE` (`quote_no` ASC) ,
  INDEX `fk_quotes_7_idx` (`level_id` ASC) ,
  INDEX `fk_quotes_8_idx` (`source_id` ASC) ,
  INDEX `fk_quotes_9_idx` (`die_manufacturer_id` ASC) ,
  INDEX `fk_quotes_10_idx` (`package_type_id` ASC) ,
  INDEX `fk_quotes_11_idx` (`process_flow_id` ASC) ,
  INDEX `fk_quotes_12_idx` (`testing_id` ASC) ,
  INDEX `fk_quotes_13_idx` (`priority_id` ASC) ,
  INDEX `fk_quotes_14_idx` (`lead_quality_id` ASC) ,
  CONSTRAINT `fk_quotes_2`
    FOREIGN KEY (`customer_id` )
    REFERENCES `iq2`.`customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_3`
    FOREIGN KEY (`owner_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_1`
    FOREIGN KEY (`status_id` )
    REFERENCES `iq2`.`status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_4`
    FOREIGN KEY (`lost_reason_id` )
    REFERENCES `iq2`.`lost_reasons` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_5`
    FOREIGN KEY (`no_bid_reason_id` )
    REFERENCES `iq2`.`no_bid_reasons` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_6`
    FOREIGN KEY (`quote_type_id` )
    REFERENCES `iq2`.`quote_types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_7`
    FOREIGN KEY (`level_id` )
    REFERENCES `iq2`.`levels` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_8`
    FOREIGN KEY (`source_id` )
    REFERENCES `iq2`.`sources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_9`
    FOREIGN KEY (`die_manufacturer_id` )
    REFERENCES `iq2`.`die_manufacturers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_10`
    FOREIGN KEY (`package_type_id` )
    REFERENCES `iq2`.`package_types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_11`
    FOREIGN KEY (`process_flow_id` )
    REFERENCES `iq2`.`process_flow` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_12`
    FOREIGN KEY (`testing_id` )
    REFERENCES `iq2`.`testing` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_13`
    FOREIGN KEY (`priority_id` )
    REFERENCES `iq2`.`priority` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_14`
    FOREIGN KEY (`lead_quality_id` )
    REFERENCES `iq2`.`lead_quality` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`stock_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`stock_items` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`stock_items` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quote_id` INT NOT NULL ,
  `part_no` VARCHAR(45) NOT NULL ,
  `manufacturer` VARCHAR(45) NULL ,
  `line_note` TEXT NULL ,
  `date_code` VARCHAR(45) NULL ,
  `qty_1_24` INT NULL ,
  `qty_25_99` INT NULL ,
  `qty_100_499` INT NULL ,
  `qty_500_999` INT NULL ,
  `qty_1000_Plus` INT NULL ,
  `qty_Base` INT NULL ,
  `qty_Custom` INT NULL ,
  `qty_NoBid` VARCHAR(45) NULL ,
  `qty_Available` INT NULL ,
  `price_1_24` DOUBLE NULL ,
  `price_25_99` DOUBLE NULL ,
  `price_100_499` DOUBLE NULL ,
  `price_500_999` DOUBLE NULL ,
  `price_1000_Plus` DOUBLE NULL ,
  `price_Base` DOUBLE NULL ,
  `price_Custom` DOUBLE NULL ,
  `last_updated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_quote_pn_1_idx` (`quote_id` ASC) ,
  CONSTRAINT `fk_quote_pn_1`
    FOREIGN KEY (`quote_id` )
    REFERENCES `iq2`.`quotes` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`roles` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`contacts` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`contacts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  `phone1` VARCHAR(45) NOT NULL ,
  `phone2` VARCHAR(45) NULL ,
  `address1` VARCHAR(45) NULL ,
  `address2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `state_id` INT NULL ,
  `zip` VARCHAR(45) NULL ,
  `country_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_contacts_1_idx` (`state_id` ASC) ,
  INDEX `fk_contacts_2_idx` (`country_id` ASC) ,
  CONSTRAINT `fk_contacts_1`
    FOREIGN KEY (`state_id` )
    REFERENCES `iq2`.`us_states` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contacts_2`
    FOREIGN KEY (`country_id` )
    REFERENCES `iq2`.`countries` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`customer_contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`customer_contacts` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`customer_contacts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `customer_id` INT NOT NULL ,
  `contact_id` INT NOT NULL ,
  INDEX `fk_customer_contact_1_idx` (`customer_id` ASC) ,
  INDEX `fk_customer_contact_2_idx` (`contact_id` ASC) ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `customer_contact_UNIQUE` (`customer_id` ASC, `contact_id` ASC) ,
  CONSTRAINT `fk_customer_contact_1`
    FOREIGN KEY (`customer_id` )
    REFERENCES `iq2`.`customers` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customer_contact_2`
    FOREIGN KEY (`contact_id` )
    REFERENCES `iq2`.`contacts` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`actions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`actions` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`actions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`audit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`audit` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`audit` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `created_on` TIMESTAMP NOT NULL ,
  `salesperson` VARCHAR(255) NOT NULL ,
  `customer` VARCHAR(255) NULL ,
  `contact` VARCHAR(255) NULL ,
  `quote_no` VARCHAR(255) NULL ,
  `item` VARCHAR(255) NULL ,
  `status` VARCHAR(255) NULL ,
  `action` VARCHAR(255) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`attachments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`attachments` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`attachments` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quote_id` INT NOT NULL ,
  `filename` VARCHAR(255) NOT NULL ,
  `content_type` VARCHAR(45) NOT NULL ,
  `size` INT NOT NULL ,
  `md5` VARCHAR(45) NOT NULL ,
  `uploaded_date` TIMESTAMP NOT NULL DEFAULT now() ,
  `uploaded_by` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_attachments_1_idx` (`quote_id` ASC) ,
  INDEX `fk_attachments_2_idx` (`uploaded_by` ASC) ,
  CONSTRAINT `fk_attachments_1`
    FOREIGN KEY (`quote_id` )
    REFERENCES `iq2`.`quotes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attachments_2`
    FOREIGN KEY (`uploaded_by` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`bto_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`bto_groups` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`bto_groups` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`bto_approvals`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`bto_approvals` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`bto_approvals` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quote_id` INT NOT NULL ,
  `group_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `approved_date` DATETIME NULL ,
  `notes` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `bto_approvals_fk2_idx` (`user_id` ASC) ,
  INDEX `fk_bto_approvals_4_idx` (`group_id` ASC) ,
  INDEX `fk_bto_approvals_1_idx1` (`quote_id` ASC) ,
  CONSTRAINT `fk_bto_approvals_2`
    FOREIGN KEY (`user_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_approvals_4`
    FOREIGN KEY (`group_id` )
    REFERENCES `iq2`.`bto_groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_approvals_1`
    FOREIGN KEY (`quote_id` )
    REFERENCES `iq2`.`quotes` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`user_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`user_roles` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`user_roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `role_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_roles_1_idx` (`user_id` ASC) ,
  INDEX `fk_user_roles_2_idx` (`role_id` ASC) ,
  CONSTRAINT `fk_user_roles_1`
    FOREIGN KEY (`user_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_roles_2`
    FOREIGN KEY (`role_id` )
    REFERENCES `iq2`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `iq2` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
