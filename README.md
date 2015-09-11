# Library

##### Dynamic library website in MySQL, _08/27/15_

#### By _**Rick Hills**_

## Description

_Library is a simple dynamic library management system in PHP / MySQL. Librarians can add books, track copies of books, track authors, and track book checkouts. Patrons can search books, check them out, view their current checkouts and checkout history._

## Setup

* Clone this repository from GitHub
* Run "composer install" in the project directory
* Start MySQL server (one option is to use MAMP)
* Start Apache server to run phpMyAdmin (can use MAMP)
* Import library.sql.zip and library_test.sql.zip using phpMyAdmin (localhost:8080/phpMyAdmin)
* Start a PHP server in the web directory (php -S localhost:8000)
* Navigate to localhost:8000 and enjoy!

## Technologies Used

PHP, phpMyAdmin, MySQL, PHPUnit, Silex, Twig, HTML, CSS, Bootstrap

### Legal

*{This is boilerplate legal language. Read through it, and if you like it, use it. There are other license agreements online, but you can generally copy and paste this.}*

Copyright (c) 2015 **Deron Johnson, Alexandra Brown, Ashlin Aronin and Rick Hills**

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
