<?php

//if using database
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";

//if using database
$server = 'mysql:host=localhost;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class StoreTest extends PHPUnit_Framework_TestCase{

    protected function tearDown()
    {
       Store::deleteAll();
    }

    function testGetName()
    {
        //Arrange
        $id = 3;
        $name = "Footlocker";
        $test_name = new Store($id, $name);

        //Act
        $result = $test_name->getName();

        //Assert
        $this->assertEquals($name, $result);
    }

   function testGetId()
   {
        //Arrange
        $id = 1;
        $name = "Shoe Depot";
        $test_id = new Store($id, $name);
        //Act
        $result = $test_id->getId();
        //Assert
        $this->assertEquals($id, $result);
   }

   // function testSave()
   // {
   //      //Arrange
   //      $id = null;
   //      $name = "Foot Bonanza";
   //      $test_store = new Store($id, $name);
   //      $test_store->save();
   //      //Act
   //      $result = Store::getAll();
   //      //Assert
   //      $this->assertEquals($test_store, $result[0]);
   //
   // }
   //
   // function testGetAll()
   // {
   //     //Arrange
   //     $id = null;
   //     $name = "Footlocker";
   //     $test_store = new Store($id, $nam);
   //     $test_store->save();
   //
   //     $id = null;
   //     $name2 = "Nic";
   //     $test_store2 = new Store($id, $name2);
   //     $test_store2->save();
   //     //Act
   //     $result = Store::getAll();
   //     //Assert
   //     $this->assertEquals([$test_store, $test_store2], $result);
   // }
   //
   // function testFind()
   // {
   //      //Arrange
   //      $id = 4;
   //      $name = "Things for Feet";
   //      $test_store = new Store($id, $name);
   //      $test_store->save();
   //
   //      //Act
   //      $result = Store::find($test_store->getId());
   //
   //      //Assert
   //      $this->assertEquals($test_store, $result);
   // }
   //
   // function testDeleteAll()
   // {
   //     //Arrange
   //     $id = null;
   //     $name = "Footlocker";
   //     $test_store = new Store($id, $nam);
   //     $test_store->save();
   //
   //     $id = null;
   //     $name2 = "Nic";
   //     $test_store2 = new Store($id, $name2);
   //     $test_store2->save();
   //
   //     //Act
   //     Store::deleteAll();
   //     $result = Store::getAll();
   //
   //     //Assert
   //     $this->assertEquals([], $result);
   // }
}
?>
