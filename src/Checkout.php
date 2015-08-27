<?php
    class Checkout
    {
        private $copy_id;
        private $patron_id;
        private $due_date;
        private $returned;
        private $id;


        function __construct($copy_id, $patron_id, $due_date, $returned = false, $id = null)
        {
            $this->copy_id = (int) $copy_id;
            $this->patron_id = (int) $patron_id;
            $this->due_date = $due_date;
            $this->returned = (int) $returned;
            $this->id = $id;
        }

        //getter and setters
        function getCopyId()
        {
            return $this->copy_id;
        }

        function getPatronId()
        {
            return $this->patron_id;
        }

        function getDueDate()
        {
            return $this->due_date;
        }

        function setDueDate($new_due_date)
        {
            $this->due_date = $new_due_date;
        }

        function getReturned()
        {
            return $this->returned;
        }

        function setReturned($new_returned)
        {
            $this->returned = (int) $new_returned;
        }

        function getId()
        {
            return $this->id;
        }

        //database methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, due_date, returned) VALUES (
                {$this->getCopyId()},
                {$this->getPatronId()},
                '{$this->getDueDate()}',
                {$this->getReturned()});"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function updateDueDate($new_due_date)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET due_date = '{$new_due_date}' WHERE id = {$this->getId()};");
            $this->setDueDate($new_due_date);
        }

        function updateReturned($new_returned)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET returned = {$new_returned} WHERE id = {$this->getId()};");
            $this->setReturned($new_returned);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE id = {$this->getId()};");
        }

        //static methods

        static function getAll()
        {
            $checkouts_query = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
            $all_checkouts = array();
            foreach ($checkouts_query as $checkout) {
                $copy_id = $checkout['copy_id'];
                $patron_id = $checkout['patron_id'];
                $due_date = $checkout['due_date'];
                $returned = $checkout['returned'];
                $id = $checkout['id'];
                $new_checkout = new Checkout($copy_id, $patron_id, $due_date, $returned, $id);
                array_push($all_checkouts, $new_checkout);
            }
            return $all_checkouts;
        }

        static function getOverdue()
        {
            // Move to app
            date_default_timezone_set("America/Los_Angeles");
            $current_date = gmdate("Y-m-d");
            $checkouts_query = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE due_date < '{$current_date}';");
            $overdue_checkouts = array();
            foreach ($checkouts_query as $checkout) {
                $copy_id = $checkout['copy_id'];
                $patron_id = $checkout['patron_id'];
                $due_date = $checkout['due_date'];
                $returned = $checkout['returned'];
                $id = $checkout['id'];
                $new_checkout = new Checkout($copy_id, $patron_id, $due_date, $returned, $id);
                array_push($overdue_checkouts, $new_checkout);
            }
            return $overdue_checkouts;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

        static function find($search_id)
        {
            $found_checkout = null;
            $all_checkouts = Checkout::getAll();
            foreach($all_checkouts as $checkout) {
                if($checkout->getId() == $search_id) {
                    $found_checkout = $checkout;
                }
            }
            return $found_checkout;
        }



    }


 ?>
