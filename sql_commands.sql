ALTER TABLE `payment` add column `balance_amount` int(11) NOT NULL;

ALTER TABLE `payment` add column `penal` int(11) NOT NULL;

ALTER TABLE `payment` add column `payment_no` varchar(100) NOT NULL;

ALTER TABLE `rate` DROP `from_area`, DROP `to_area`;

ALTER TABLE `rate` ADD `extra` INT(11) NOT NULL AFTER `flag`;

-----------------

create table order_rate ( order_rate_id int PRIMARY KEY AUTO_INCREMENT, start_date date, end_date date, amount1 int, amount2 int, flag tinyint, order_id int, CONSTRAINT order_rate_fk FOREIGN KEY (order_id) REFERENCES orders(order_id) )