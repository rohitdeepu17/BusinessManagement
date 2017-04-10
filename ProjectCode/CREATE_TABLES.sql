CREATE DATABASE Business;

USE Business;

CREATE TABLE category(
		cat_id int PRIMARY KEY AUTO_INCREMENT,
		cat_name varchar(20) UNIQUE,
		cat_details varchar(50)
		);
		
CREATE TABLE product(
		prod_id int PRIMARY KEY AUTO_INCREMENT,
		prod_name varchar(20) UNIQUE,
		cat_name int REFERENCES category(cat_name),
		stock real,
		unit_sale_price real,
		unit_cost_price real,
		prod_details varchar(50)
		);
		
CREATE TABLE customer(
		cust_id int PRIMARY KEY AUTO_INCREMENT,
		cust_name varchar(20),
		father_name varchar(20),
		phone bigint(10),
		address varchar(20),
		other_details varchar(50)
		);
		
CREATE TABLE bill(
		bill_no int PRIMARY KEY AUTO_INCREMENT,
		bill_date date,
		amount real,
		discount real,
		paid_amount real,
		profit real,
		cust_id int REFERENCES customer(cust_id)
		);

CREATE TABLE billcontent(
		bill_no int REFERENCES bill(bill_no),
		prod_id int REFERENCES product(prod_id),
		qty real,
		unit_price real,
		PRIMARY KEY(bill_no, prod_id)
		);
		
CREATE TABLE salepayment(
		transaction_no int PRIMARY KEY AUTO_INCREMENT,
		bill_no int REFERENCES bill(bill_no),
		transaction_date date,
		transaction_amount real,
		transaction_mode int
		);
