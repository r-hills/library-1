<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Patron.php";
    require_once "src/Checkout.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);

            //Act
            $result = $test_patron->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);

            //Act
            $test_patron->save();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($test_patron, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            $name2 = "Tac Zoltani";
            $phone2 = "1-800-407-3930";
            $test_patron2 = new Patron($name2, $phone2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            $name2 = "Tac Zoltani";
            $phone2 = "1-800-407-3930";
            $test_patron2 = new Patron($name2, $phone2);
            $test_patron2->save();

            //Act
            Patron::deleteAll();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            $name2 = "Tac Zoltani";
            $phone2 = "1-800-407-3930";
            $test_patron2 = new Patron($name2, $phone2);
            $test_patron2->save();

            //Act
            $result = Patron::find($test_patron2->getId());

            //Assert
            $this->assertEquals($test_patron2, $result);
        }

        // test that update method is working for name
        function test_updateName()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            // $column_to_update = "name";
            $new_name = "Suzie Q";

            //Act
            $test_patron->updateName($new_name);

            //Assert
            $result = Patron::getAll();
            $this->assertEquals("Suzie Q", $result[0]->getName());
        }

        // test that same update method is working for phone
        function test_updatePhone()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            $new_phone = "570-943-0483";

            //Act
            $test_patron->updatePhone($new_phone);

            //Assert
            $result = Patron::getAll();
            $this->assertEquals("570-943-0483", $result[0]->getPhone());
        }

        function test_delete()
        {
            //Arrange
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            $name2 = "Tac Zoltani";
            $phone2 = "1-800-407-3930";
            $test_patron2 = new Patron($name2, $phone2);
            $test_patron2->save();

            //Act
            $test_patron->delete();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($test_patron2, $result[0]);
        }


        function test_getCurrentCheckouts()
        {
            //Arrange
            // create 2 test patrons.
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            $name2 = "Tac Zoltani";
            $phone2 = "1-800-407-3930";
            $test_patron2 = new Patron($name2, $phone2);
            $test_patron2->save();

            // create 2 test checkouts. hard code copy_id for now
            $copy_id = 1;
            $due_date = "2015-03-04";
            $test_checkout = new Checkout($copy_id, $test_patron2->getId(), $due_date);
            $test_checkout->save();

            // initialize one checkout as returned to make sure that getCurrentCheckouts
            // only gets current checkouts and not just all of them
            $copy_id2 = 2;
            $due_date2 = "2011-03-04";
            $returned = true;
            $test_checkout2 = new Checkout($copy_id2, $test_patron2->getId(), $due_date2, $returned);
            $test_checkout2->save();

            //Act
            $result = $test_patron2->getCurrentCheckouts();

            //Assert
            $this->assertEquals([$test_checkout], $result);
        }

        function test_getAllCheckouts()
        {
            //Arrange
            // create 2 test patrons.
            $name = "Suzie Palloozi";
            $phone = "1-800-439-0398";
            $test_patron = new Patron($name, $phone);
            $test_patron->save();

            // create 2 test checkouts. hard code copy_id for now
            $copy_id = 1;
            $patron_id = $test_patron->getId();
            $due_date = "2015-03-04";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);
            $test_checkout->save();

            //Act
            $result = $test_patron->getAllCheckouts();

            //Assert
            $this->assertEquals([$test_checkout], $result);
        }
    }

 ?>
