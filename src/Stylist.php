<?php
    class Stylist{
        private $name;
        private $id;

        function __construct($name, $id = null){
            $this->name = $name;
            $this->id = $id;
        }

        function getName(){
            return $this->name;
        }

        function setName(){
            $this->name = $name;
        }

        function getId(){
            return $this->id;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach($returned_stylists as $stylist) {
                $name = $stylist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }

        static function find($search_id){
            $found_stylist = null;
            $stylists = Stylist::getAll();
            foreach($stylists as $stylist) {
              $stylist_id = $stylist->getId();
              if ($stylist_id == $search_id) {
                $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }

        function getClients(){
            $clients = array();
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()};");
            // var_export($returned_clients);
            foreach($returned_clients as $client){
                $name = $client['name'];
                $email = $client['email'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($name, $email, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }
    }
?>
