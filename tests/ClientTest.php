<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class ClientTest extends PHPUnit_Framework_TestCase{

        protected function tearDown(){
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_save()
        {
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Eric Slickhair";
            $email = "eslickhair@email.com";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $email, $id, $stylist_id);
            $test_client->save();

            $result = Client::getAll();

            $this->assertEquals($test_client, $result[0]);
        }

        function test_getId()
        {
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Eric Slickhair";
            $email = "eslickhair@email.com";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $email, $id, $stylist_id);
            $test_client->save();

            $result = $test_client->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_getStylistId(){
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Eric Slickhair";
            $email = "eslickhair@email.com";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $email, $id, $stylist_id);
            $test_client->save();

            $result = $test_client->getStylistId();

            $this->assertEquals(true, is_numeric($result));
        }

        function test_getAll()
        {
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Eric Slickhair";
            $email = "eslickhair@email.com";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $email, $id, $stylist_id);
            $test_client->save();

            $client_name2 = "Paul Styles";
            $email2 = "pstyles@email.com";
            $test_client2 = new Client($client_name2, $email2, $id, $stylist_id);
            $test_client2->save();

            $result = Client::getAll();

            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $client_name = "Eric Slickhair";
            $email = "eslickhair@email.com";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($client_name, $email, $id, $stylist_id);
            $test_client->save();

            $client_name2 = "Paul Styles";
            $email2 = "pstyles@email.com";
            $test_client = new Client($client_name2, $email2, $id, $stylist_id);
            $test_client->save();

            Client::deleteAll();
            $result = Client::getAll();

            $this->assertEquals([], $result);
        }

        function test_find(){
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $stylist_id = $test_stylist->getId();

            $client_name = "Eric Slickhair";
            $email = "eslickhair@email.com";
            $client_name2 = "Paul Styles";
            $email2 = "eslickhair@email.com";
            $test_client = new Client($client_name, $email, $id, $stylist_id);
            $test_client2 = new Client($client_name2, $email2, $id, $stylist_id);
            $test_client->save();
            $test_client2->save();

            $result = Client::find($test_client->getId());
            
            $this->assertEquals($test_client, $result);
        }
    }
?>
