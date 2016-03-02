<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class TaskTest extends PHPUnit_Framework_TestCase{
        protected function tearDown(){
            Client::deleteAll();
            Stylist::deleteAll();
        }
        function test_save()
        {
            $name = "Eric Slickhair";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();
            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $category_id);
            $test_task->save();
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }
        function test_getId()
        {
            //Arrange
            $stylist_name = "Jenn Johnson";
            $id = null;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();
            $client_name = "Eric Slickhair";
            $stylist_id = $test_stylist->getId();
            $test_task = new Task($description, $id, $category_id);
            $test_task->save();
            $result = $test_task->getId();
            $this->assertEquals(true, is_numeric($result));
        }
        function test_getCategoryId(){
            $name = "Home Stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();
            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $category_id);
            $test_task->save();
            $result = $test_task->getCategoryId();
            $this->assertEquals(true, is_numeric($result));
        }
        function test_getAll()
        {
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();
            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $category_id);
            $test_task->save();
            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id, $category_id);
            $test_task2->save();
            $result = Task::getAll();
            $this->assertEquals([$test_task, $test_task2], $result);
        }
        function test_deleteAll()
        {
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();
            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $category_id);
            $test_task->save();
            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id, $category_id);
            $test_task2->save();
            Task::deleteAll();
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }
        function test_find(){
            $name = "Home Stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();
            $category_id = $test_category->getId();
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_task = new Task($description, $id, $category_id);
            $test_task2 = new Task($description2, $id, $category_id);
            $test_task->save();
            $test_task2->save();
            $result = Task::find($test_task->getId());
            $this->assertEquals($test_task, $result);
        }
    }
?>
