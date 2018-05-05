ALTER TABLE `payment` add column `balance_amount` int(11) NOT NULL;

ALTER TABLE `payment` add column `penal` int(11) NOT NULL;

ALTER TABLE `payment` add column `payment_no` varchar(100) NOT NULL;

ALTER TABLE `rate` DROP `from_area`, DROP `to_area`;

ALTER TABLE `rate` ADD `extra` INT(11) NOT NULL AFTER `flag`;


new

alter table payment add column tax int(11) not null;

alter table payment add column lease_rent int(11) not null;

create table order_rate ( order_rate_id int PRIMARY KEY AUTO_INCREMENT, start_date date, end_date date, amount1 int, amount2 int, flag tinyint, order_id int, CONSTRAINT order_rate_fk FOREIGN KEY (order_id) REFERENCES orders(order_id) )

create table debit(
debit_id int(11) not null PRIMARY key AUTO_INCREMENT,
penal int not null,
invoice_id int,
FOREIGN KEY (invoice_id) REFERENCES invoice(invoice_id)
);




alter table debit add payment_id int;

alter table debit add CONSTRAINT fk1 FOREIGN KEY (payment_id) REFERENCES payment(payment_id);

alter table debit add order_id int;

alter table debit add CONSTRAINT fk_debit_order FOREIGN KEY (order_id) REFERENCES orders(order_id);