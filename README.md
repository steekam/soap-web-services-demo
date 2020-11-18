# SOAP Web Services Demo

A simple `Student Manager Service` that exposes a method to fetch a student record by an admission number.

## Prerequisites
- PHP 7.4+
- PHP SQLite extensions enabled

## Project Setup
>Make sure you are in the project root directory while running any command

- Migrate the database
```bash
php migrate.php
```

- Seed the database with 10 records (Optional)
```bash
php seed.php
```

## Running the web service server
You can use the internal php server by running:
```bash
./bin/server.sh
```
The server is now accessible on http://localhost:8080/

To acess the web service WSDL file, go to: http://localhost:8080/index.php?wsdl

Registration new student records and view existing records: http://localhost:8080/register.php

## Running the client
You can use the internal php server by running:
```bash
./bin/client.sh
```
The server is now accessible on http://localhost:8090/index.php