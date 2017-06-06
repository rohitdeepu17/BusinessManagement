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
		cat_name varchar(20) REFERENCES category(cat_name),
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
		copy_no int,
		page_no int,
		bill_date date,
		amount real,
		discount real,
		paid_amount real,
		profit real,
		cust_id int REFERENCES customer(cust_id)
		);

CREATE TABLE billcontent(
		bill_no int,
		prod_id int,
		qty real,
		unit_price real,
		PRIMARY KEY(bill_no, prod_id),
		CONSTRAINT bill_bcfk_1 
  		FOREIGN KEY (bill_no) 
  		REFERENCES bill(bill_no) 
  		ON DELETE CASCADE,
  		CONSTRAINT bill_bcfk_2 
  		FOREIGN KEY (prod_id) 
  		REFERENCES product(prod_id) 
  		ON DELETE CASCADE
		);
		
CREATE TABLE salepayment(
		transaction_no int PRIMARY KEY AUTO_INCREMENT,
		bill_no int,
		transaction_date date,
		transaction_amount real,
		transaction_mode int,
		CONSTRAINT bill_spfk_1 
  		FOREIGN KEY (bill_no) 
  		REFERENCES bill(bill_no) 
  		ON DELETE CASCADE
		);
		
CREATE TABLE vendor(
		vendor_id int PRIMARY KEY AUTO_INCREMENT,
		vendor_name varchar(30),
		address varchar(20),
		phone bigint(10),
		person_name varchar(20),
		bank_account bigint(20),
		ifsc_code varchar(11),
		balance real,
		other_details varchar(50)
		);
		
CREATE TABLE vendor_transaction(
		vt_id int PRIMARY KEY AUTO_INCREMENT,
		vendor_id int,
		transaction_date date,
		transaction_amount real,
		transaction_mode int,
		transaction_type int,
		transaction_details varchar(40),
		CONSTRAINT vendor_vtfk_1 
  		FOREIGN KEY (vendor_id) 
  		REFERENCES vendor(vendor_id) 
  		ON DELETE CASCADE
		);
