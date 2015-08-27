<?php
    class Patron
    {
        private $name;
        private $phone;
        private $id;

        function __construct($name, $phone, $id = null)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->id = $id;
        }

        //getters and setters
        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function setPhone($new_phone)
        {
            $this->phone = $new_phone;
        }

        function getId()
        {
            return $this->id;
        }

        //database methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name, phone) VALUES (
                '{$this->getName()}',
                '{$this->getPhone()}');"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }


        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function updatePhone($new_phone)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET phone = '{$new_phone}' WHERE id = {$this->getId()};");
            $this->setPhone($new_phone);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            // when we delete a patron, should we also delete their checkouts?
        }



        // Methods dealing with checkouts
        // function addCheckout($new_checkout)
        // {
        //     $statement = $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, due_date, returned) VALUES (
        //         {$new_checkout->getCopyId()},
        //         {$new_checkout->getPatronId()},
        //         '{$new_checkout->getDueDate()}',
        //         {$new_checkout->getReturned()});");
        //
        // }

        function addCheckout($new_checkout)
        {
            $statement = $GLOBALS['DB']->exec("INSERT INTO checkouts (copy_id, patron_id, returned, due_date) VALUES (
                {$new_checkout->getCopyId()},
                {$new_checkout->getPatronId()},
                {$new_checkout->getReturned()},
                '{$new_checkout->getDueDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();

        }

        function getCurrentCheckouts()
        {
            $checkouts_query = $GLOBALS['DB']->query("SELECT * FROM checkouts
                WHERE patron_id = {$this->getId()} AND returned = 0;");

            $current_checkouts = array();
            foreach ($checkouts_query as $checkout) {
                $copy_id = $checkout['copy_id'];
                $patron_id = $checkout['patron_id'];
                $due_date = $checkout['due_date'];
                $returned = $checkout['returned'];
                $id = $checkout['id'];
                $new_checkout = new Checkout($copy_id, $patron_id, $due_date, $returned, $id);
                array_push($current_checkouts, $new_checkout);
            }
            return $current_checkouts;
        }

        function getAllCheckouts()
        {
            $checkouts_query = $GLOBALS['DB']->query("SELECT * FROM checkouts
                WHERE patron_id = {$this->getId()};");

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




        //static methods
        static function getAll()
        {
            $patrons_query = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $all_patrons = array();
            foreach ($patrons_query as $patron) {
                $name = $patron['name'];
                $phone = $patron['phone'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $phone, $id);
                array_push($all_patrons, $new_patron);
            }
            return $all_patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function find($search_id)
        {
            $found_patron = null;
            $all_patrons = Patron::getAll();
            foreach ($all_patrons as $patron) {
                if ($patron->getId() == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }
    }
?>
