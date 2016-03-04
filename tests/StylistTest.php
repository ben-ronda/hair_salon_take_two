<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_save(){
            $name = "Ben Stiller";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $result = Stylist::getAll();

            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll(){
            $name = "Ben Stiller";
            $name2 = "Derek Zoolander";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            $result = Stylist::getAll();

            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            $name = "Ben Stiller";
            $name2 = "Derek Zoolander";
            $test_stylist = new Stylist($name);
            $test_stylist->save();
            $test_stylist2 = new Stylist($name2);
            $test_stylist2->save();

            Stylist::deleteAll();
            $result = Stylist::getAll();

            $this->assertEquals([], $result);
        }

        function test_getClient(){
          $name = "Ben Stiller";
          $id = 1;
          $test_stylist = new Stylist($name, $id);
          $test_stylist->save();
          $test_stylist_id = $test_stylist->getId();

          $client_name = "Ben Ronda";
          $email = "bronda@email.com";
          $id2 = 2;
          $test_client = new Client($client_name, $email, $id2, $test_stylist_id);
          $test_client->save();

          $client_name2 = "Kyle";
          $email2 = "kyle@email.com";
          $id3 = 3;
          $test_task2 = new Client($client_name2, $email2, $id3, $test_stylist_id);
          $test_task2->save();

          $result = $test_stylist->getClients();

          $this->assertEquals([$test_client, $test_client2], $result);
        }

    }
?>
