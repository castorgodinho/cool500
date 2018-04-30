ALTER TABLE `payment` add column `balance_amount` int(11) NOT NULL;

ALTER TABLE `payment` add column `payment_no` varchar(100) NOT NULL;

ALTER TABLE `rate` DROP `from_area`, DROP `to_area`;

ALTER TABLE `rate` ADD `extra` INT(11) NOT NULL AFTER `flag`;
