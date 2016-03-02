<?php
    class Client{
        private $client_name;
        private $stylist_id;
        private $email;
        private $id;

        function __construct($client_name, $email, $id = null, $stylist_id){
            $this->client_name = $client_name;
            $this->email = $email;
            $this->id = $id;
            $this->stylist_id = $stylist_id;
        }

        function setClientName($new_client_name){
            $this->client_name = (string) $new_client_name;
        }

        function getClientName(){
            return $this->client_name;
        }

        function setEmail($new_email){
            $this->email = $new_email;
        }

        function getEmail(){
            return $this->email;
        }

        function getStylistId(){
            return $this->stylist_id;
        }

        function getId(){
            return $this->id;
        }

        function save(){
            $GLOBALS['DB']->exec("INSERT INTO clients (name, email, stylist_id) VALUES ('{$this->getClientName()}','{$this->getEmail()}', {$this->getStylistId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll(){
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client){
                $client_name = $client['name'];
                $email = $client['email'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($client_name, $email, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function find($search_id){
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client){
                $client_id = $client->getId();
                if($client_id == $search_id){
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        static function deleteALL(){
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }
    }
?>
