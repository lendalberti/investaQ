SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


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
-- Table `iq2`.`classes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`classes` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`classes` (
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
-- Table `iq2`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`roles` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`users` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `role_id` INT NOT NULL ,
  `group_id` INT NULL ,
  `username` VARCHAR(45) NULL ,
  `first_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `email` VARCHAR(45) NULL ,
  `title` VARCHAR(45) NULL ,
  `phone` VARCHAR(45) NULL ,
  `fax` VARCHAR(45) NULL ,
  `sig` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_users_1_idx` (`role_id` ASC) ,
  CONSTRAINT `fk_users_1`
    FOREIGN KEY (`role_id` )
    REFERENCES `iq2`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
  `zip` VARCHAR(45) NULL ,
  `country_id` INT NOT NULL ,
  `class_id` INT NULL ,
  `region_id` INT NULL ,
  `territories` VARCHAR(45) NULL ,
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
  INDEX `fk_customers_3_idx` (`class_id` ASC) ,
  INDEX `fk_customers_4_idx` (`region_id` ASC) ,
  INDEX `fk_customers_5_idx` (`tier_id` ASC) ,
  INDEX `fk_customers_6_idx` (`parent_id` ASC) ,
  INDEX `fk_customers_7_idx` (`inside_salesperson_id` ASC) ,
  INDEX `fk_customers_8_idx` (`outside_salesperson_id` ASC) ,
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
    FOREIGN KEY (`class_id` )
    REFERENCES `iq2`.`classes` (`id` )
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
-- Table `iq2`.`quotes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`quotes` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`quotes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quote_no` VARCHAR(45) NOT NULL ,
  `status_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `customer_id` INT NOT NULL ,
  `additional_notes` TEXT NULL ,
  `terms_conditions` TEXT NULL ,
  `created` TIMESTAMP NOT NULL DEFAULT NOW() ,
  `updated` DATETIME NULL ,
  `customer_acknowledgment` TEXT NULL ,
  `risl` TEXT NULL ,
  `manufacturing_lead_time` TEXT NULL ,
  `expiration_date` DATETIME NOT NULL ,
  `lost_reason_id` INT NULL DEFAULT 1 ,
  `no_bid_reason_id` INT NULL DEFAULT 1 ,
  `ready_to_order` INT NULL ,
  `type` INT NOT NULL DEFAULT false ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_quotes_2_idx` (`customer_id` ASC) ,
  INDEX `fk_quotes_3_idx` (`user_id` ASC) ,
  INDEX `fk_quotes_1_idx` (`status_id` ASC) ,
  INDEX `fk_quotes_4_idx` (`lost_reason_id` ASC) ,
  INDEX `fk_quotes_5_idx` (`no_bid_reason_id` ASC) ,
  CONSTRAINT `fk_quotes_2`
    FOREIGN KEY (`customer_id` )
    REFERENCES `iq2`.`customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quotes_3`
    FOREIGN KEY (`user_id` )
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
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`items` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`items` (
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
-- Table `iq2`.`types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`types` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
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
-- Table `iq2`.`history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`history` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`history` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `quote_id` INT NOT NULL ,
  `quote_no` VARCHAR(45) NOT NULL ,
  `part_no` VARCHAR(45) NOT NULL ,
  `created` DATETIME NULL ,
  `type_id` INT NULL ,
  `manufacturer` VARCHAR(45) NULL ,
  `date_code` VARCHAR(45) NULL ,
  `customer_id` INT NULL ,
  `location` VARCHAR(255) NULL ,
  `contact_id` INT NULL ,
  `salesperson_id` INT NULL ,
  `status_id` INT NULL ,
  `lost_reason_id` INT NULL ,
  `no_bid_reason_id` INT NULL ,
  `quantity` INT NULL ,
  `unit_price` FLOAT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_history_1_idx` (`type_id` ASC) ,
  INDEX `fk_history_2_idx` (`status_id` ASC) ,
  INDEX `fk_history_3_idx` (`customer_id` ASC) ,
  INDEX `fk_history_4_idx` (`salesperson_id` ASC) ,
  INDEX `fk_history_5_idx` (`quote_id` ASC) ,
  INDEX `fk_history_6_idx` (`lost_reason_id` ASC) ,
  INDEX `fk_history_7_idx` (`no_bid_reason_id` ASC) ,
  INDEX `fk_history_8_idx` (`contact_id` ASC) ,
  CONSTRAINT `fk_history_1`
    FOREIGN KEY (`type_id` )
    REFERENCES `iq2`.`types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_2`
    FOREIGN KEY (`status_id` )
    REFERENCES `iq2`.`status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_3`
    FOREIGN KEY (`customer_id` )
    REFERENCES `iq2`.`customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_4`
    FOREIGN KEY (`salesperson_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_5`
    FOREIGN KEY (`quote_id` )
    REFERENCES `iq2`.`quotes` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_6`
    FOREIGN KEY (`lost_reason_id` )
    REFERENCES `iq2`.`lost_reasons` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_7`
    FOREIGN KEY (`no_bid_reason_id` )
    REFERENCES `iq2`.`no_bid_reasons` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_history_8`
    FOREIGN KEY (`contact_id` )
    REFERENCES `iq2`.`contacts` (`id` )
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
-- Table `iq2`.`business_class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`business_class` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`business_class` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
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
-- Table `iq2`.`testing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`testing` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`testing` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`bto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`bto` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`bto` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `status_id` INT NOT NULL ,
  `quote_no` VARCHAR(45) NOT NULL ,
  `owner_id` INT NOT NULL ,
  `updated` DATETIME NOT NULL ,
  `created` DATETIME NOT NULL ,
  `customer_id` INT NOT NULL ,
  `requested_part_number` VARCHAR(45) NOT NULL ,
  `generic_part_number` VARCHAR(45) NULL ,
  `quantity` VARCHAR(45) NOT NULL ,
  `die_manufacturer_id` INT NOT NULL ,
  `package_type_id` INT NOT NULL ,
  `lead_count` INT NOT NULL ,
  `process_flow_id` INT NOT NULL ,
  `business_class_id` INT NOT NULL ,
  `testing_id` INT NOT NULL ,
  `priority_id` INT NOT NULL ,
  `temp_low` VARCHAR(45) NULL ,
  `temp_high` VARCHAR(45) NULL ,
  `ncnr` TINYINT(1) NOT NULL DEFAULT false ,
  `itar` TINYINT(1) NOT NULL DEFAULT false ,
  `have_die` TINYINT(1) NOT NULL DEFAULT false ,
  `spa` TINYINT(1) NOT NULL DEFAULT false ,
  `recreation` TINYINT(1) NOT NULL DEFAULT false ,
  `wip_product` TINYINT(1) NOT NULL DEFAULT false ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_bto_1_idx` (`customer_id` ASC) ,
  INDEX `fk_bto_2_idx` (`package_type_id` ASC) ,
  INDEX `fk_bto_3_idx` (`die_manufacturer_id` ASC) ,
  INDEX `fk_bto_4_idx` (`process_flow_id` ASC) ,
  INDEX `fk_bto_5_idx` (`business_class_id` ASC) ,
  INDEX `fk_bto_6_idx` (`testing_id` ASC) ,
  INDEX `fk_bto_7_idx` (`priority_id` ASC) ,
  INDEX `fk_bto_8_idx` (`owner_id` ASC) ,
  INDEX `fk_bto_9_idx` (`status_id` ASC) ,
  CONSTRAINT `fk_bto_1`
    FOREIGN KEY (`customer_id` )
    REFERENCES `iq2`.`customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_2`
    FOREIGN KEY (`package_type_id` )
    REFERENCES `iq2`.`package_types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_3`
    FOREIGN KEY (`die_manufacturer_id` )
    REFERENCES `iq2`.`die_manufacturers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_4`
    FOREIGN KEY (`process_flow_id` )
    REFERENCES `iq2`.`process_flow` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_5`
    FOREIGN KEY (`business_class_id` )
    REFERENCES `iq2`.`business_class` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_6`
    FOREIGN KEY (`testing_id` )
    REFERENCES `iq2`.`testing` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_7`
    FOREIGN KEY (`priority_id` )
    REFERENCES `iq2`.`priority` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_8`
    FOREIGN KEY (`owner_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_9`
    FOREIGN KEY (`status_id` )
    REFERENCES `iq2`.`status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iq2`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `iq2`.`groups` ;

CREATE  TABLE IF NOT EXISTS `iq2`.`groups` (
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
  `bto_id` INT NOT NULL ,
  `status_id` INT NOT NULL ,
  `group_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `created_date` DATETIME NOT NULL ,
  `approved_date` DATETIME NULL ,
  `notes` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `bto_approvals_fk1_idx` (`bto_id` ASC) ,
  INDEX `bto_approvals_fk2_idx` (`user_id` ASC) ,
  INDEX `fk_bto_approvals_1_idx` (`status_id` ASC) ,
  INDEX `fk_bto_approvals_4_idx` (`group_id` ASC) ,
  CONSTRAINT `fk_bto_approvals_1`
    FOREIGN KEY (`bto_id` )
    REFERENCES `iq2`.`bto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_approvals_2`
    FOREIGN KEY (`user_id` )
    REFERENCES `iq2`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_approvals_3`
    FOREIGN KEY (`status_id` )
    REFERENCES `iq2`.`status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bto_approvals_4`
    FOREIGN KEY (`group_id` )
    REFERENCES `iq2`.`groups` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `iq2`.`types`
-- -----------------------------------------------------
START TRANSACTION;
USE `iq2`;
INSERT INTO `iq2`.`types` (`id`, `name`) VALUES (1, 'Warehouse');
INSERT INTO `iq2`.`types` (`id`, `name`) VALUES (2, 'Manufacturing');

COMMIT;
