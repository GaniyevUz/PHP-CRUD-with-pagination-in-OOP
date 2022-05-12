# PHP-CRUD-with-pagination-in-OOP

**A simple PHP Class example for using with MySQL create, read, update and delete functions. Using OOP this class can easily be added to to enhance existing functions or create more.**

**Using The Class**
--
[live  DEMO version is here](http://jahongir.ga/php-crud-with-pagination-in-oop/)

**Database Credentials**

You will need to change some variable values in the Class, that represent those of your own database. Change the following -

```php
    private $host = 'localhost';    // Change as required
    private $username = 'username';     // Change as required
    private $password = 'password';         // Change as required
    private $database = 'database'; // Change as required
```

**Test MySQL**

Start by creating a test table in your database -

```mysql
CREATE TABLE IF NOT EXISTS people (
    id int(11) NOT NULL AUTO_INCREMENT, 
    name VARCHAR(50) NOT NULL, 
    email VARCHAR(50) NOT NULL, 
    address VARCHAR(50) NOT NULL, 
    phone VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
); 

insert into people (id, name, email, address, phone) values (1, 'Mark', 'mgheeraert0@fda.gov', '97 Jackson Street', '+86 (483) 407-5836'); 
insert into people (id, name, email, address, phone) values (2, 'Leanna', 'laslam1@squarespace.com', '004 Burrows Center', '+51 (844) 722-3517'); 
insert into people (id, name, email, address, phone) values (3, 'Francisco', 'fdurran2@marriott.com', '999 Jay Place', '+380 (999) 893-5314'); 
insert into people (id, name, email, address, phone) values (4, 'Wynne', 'wnewart3@merriam-webster.com', '135 Petterle Plaza', '+33 (474) 557-2358'); 
insert into people (id, name, email, address, phone) values (5, 'Elise', 'estaddart4@youtube.com', '86199 Sullivan Way', '+385 (706) 576-4876'); 
```

**Create Example**

Use the following code to select * rows from the databse using this class

```php
<?php
include('class/crud.php');
$crud = new CRUD;
$data = [
    'name' => 'Jakhongir Ganiev',
    'email' => 'Jahongir0804@gmail.com',
    'address' => 'Uzbekistan, Namangan',
    'phone' => '+998 (94) 434 08-04'
    ];
$crud->create($data)
print_r($crud->message);
```
**Update Example**

Use the following code to update rows in the database using this class

```php
<?php
include('class/crud.php');
$crud = new CRUD;
$data = [
    'name' => 'Jakhongir Ganiev',           // can be anything to change 
    'email' => 'Jahongir0804@gmail.com',    // can be anything to change 
    'address' => 'Uzbekistan, Namangan',    // can be anything to change 
    'phone' => '+998 (94) 434 08-04'        // can be anything to change 
    ];
$crud->update($data)
print_r($crud->message);
```

**Delete Example**

Use the following code to delete rows from the database with this class

```php
<?php
include('class/crud.php');
$crud = new CRUD;
$id = 1; // identification (ID) number that you want to delete 
$crud->delete($id)
print_r($crud->message);
```

**Full SQL Example**

Use the following code to enter the full SQL query

```php
<?php
$db = new db_handler;
$db->select('people');
$db->query("SELECT * FROM `people`");

$fetch = $db->fetch_all();
/*
 *   // optional limit and offset
 *   $fetch = $db->fetch_all(5, 10);
 */
print_r($fetch); 
```
### Screenshots
<p align="center">

<img  width="25%" height="25%" src="./ss/create.jpg">

<img  width="25%" height="25%" src="./ss/read.jpg">

<img  width="25%" height="25%" src="./ss/update.jpg">

<img  width="25%" height="25%" src="./ss/delete.jpg">

<img  width="25%" height="25%" src="./ss/pagination.jpg">
