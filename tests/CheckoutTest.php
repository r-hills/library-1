<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Checkout.php";
    // require_once "src/Author.php";
    // require_once "src/Book.php";
    // require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Checkout::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $copy_id = 1;
            $patron_id = 4;
            $due_date = "2015-09-03";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);

            //Act
            $test_checkout->save();

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals($test_checkout, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $copy_id = 1;
            $patron_id = 4;
            $due_date = "2015-09-03";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);
            $test_checkout->save();

            $copy_id2 = 2;
            $patron_id2 = 1;
            $due_date2 = "2015-10-05";
            $test_checkout2 = new Checkout($copy_id2, $patron_id2, $due_date2);
            $test_checkout2->save();

            //Act
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals([$test_checkout, $test_checkout2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $copy_id = 1;
            $patron_id = 4;
            $due_date = "2015-09-03";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);
            $test_checkout->save();

            $copy_id2 = 2;
            $patron_id2 = 1;
            $due_date2 = "2015-10-05";
            $test_checkout2 = new Checkout($copy_id2, $patron_id2, $due_date2);
            $test_checkout2->save();

            //Act
            Checkout::deleteAll();

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals([], $result);
        }


        function test_updateDueDate()
        {
            //Arrange
            $copy_id = 1;
            $patron_id = 4;
            $due_date = "2015-09-03";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);
            $test_checkout->save();

            //Act
            $new_due_date = "2015-10-03";
            $test_checkout->updateDueDate($new_due_date);

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals($new_due_date, $result[0]->getDueDate());
        }

        function test_delete()
        {
            //Arrange
            $copy_id = 1;
            $patron_id = 4;
            $due_date = "2015-09-03";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);
            $test_checkout->save();

            $copy_id2 = 2;
            $patron_id2 = 1;
            $due_date2 = "2015-10-05";
            $test_checkout2 = new Checkout($copy_id2, $patron_id2, $due_date2);
            $test_checkout2->save();

            //Act
            $test_checkout->delete();

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals([$test_checkout2], $result);
        }

        function test_find()
        {
            //Arrange
            $copy_id = 1;
            $patron_id = 4;
            $due_date = "2015-09-03";
            $test_checkout = new Checkout($copy_id, $patron_id, $due_date);
            $test_checkout->save();

            $copy_id2 = 2;
            $patron_id2 = 1;
            $due_date2 = "2015-10-05";
            $test_checkout2 = new Checkout($copy_id2, $patron_id2, $due_date2);
            $test_checkout2->save();

            //Act
            $result = Checkout::find($test_checkout2->getId());

            //Assert
            $this->assertEquals($test_checkout2, $result);
        }

    }
 ?>
