<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Store.php";
require_once "src/Brand.php";

//if using database
$server = 'mysql:host=localhost;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class BrandTest extends PHPUnit_Framework_TestCase{

    protected function tearDown()
    {
       Brand::deleteAll();
    }

    function testGetName()
    {
        //Arrange
        $id = 3;
        $name = "Vans";
        $test_name = new Brand($id, $name);

        //Act
        $result = $test_name->getName();

        //Assert
        $this->assertEquals($name, $result);
    }

   function testGetId()
   {
        //Arrange
        $id = 1;
        $name = "Converse";
        $test_id = new Brand($id, $name);

        //Act
        $result = $test_id->getId();

        //Assert
        $this->assertEquals($id, $result);
   }

   function testSave()
   {
        //Arrange
        $id = 1;
        $name = "Nike";
        $test_brand = new Brand($id, $name);
        $test_brand->save($name);

        $id2 = 2;
        $name2 = "Reebok";
        $test_brand2 = new Brand($id, $name2);
        $test_brand2->save($name2);

        $id3 = 3;
        $name3 = "Nike";
        $test_brand3 = new Brand($id3, $name3);
        $test_brand3->save($name3);


        //Act
        $result = Brand::getAll();

        //Assert
        $this->assertEquals([$test_brand, $test_brand2] , $result);

   }

   function testGetAll()
   {
       //Arrange
       $id = 1;
       $name = "Vans";
       $test_brand = new Brand($id, $name);
       $test_brand->save($name);

       $id = 2;
       $name2 = "Emerica";
       $test_brand2 = new Brand($id, $name2);
       $test_brand2->save($name2);

       //Act
       $result = Brand::getAll();

       //Assert
       $this->assertEquals([$test_brand, $test_brand2], $result);
   }

   function testFind() {
       //Arrange
       $id = 1;
       $name = "Nike";
       $test_brand = new Brand($id, $name);
       $test_brand->save($name);

       //Act
       $result = Brand::find($test_brand->getId());

       //Assert
       $this->assertEquals($test_brand, $result);
   }

   function testUpdate() {
       //Arrange
       $id = 1;
       $name = "Nike";
       $test_brand = new Brand($id, $name);
       $test_brand->save($name);
       $new_name = "Reebok";

       //Act
       $test_brand->update($new_name);
       $result = $test_brand->getName();


       //Assert
       $this->assertEquals($new_name, $result);
   }

   function testDelete()
   {
       //Arrange
       $id = 1;
       $name = "Vans";
       $test_brand = new Brand($id, $name);
       $test_brand->save($name);

       $id = 2;
       $name2 = "Emerica";
       $test_brand2 = new Brand($id, $name2);
       $test_brand2->save($name2);

       //Act
       $test_brand->delete();
       $result = Brand::getAll();

       //Assert
       $this->assertEquals([$test_brand2], $result);
   }

   function testAddStore()
   {
       //Arrange
       $id = 1;
       $name = "Vans";
       $test_brand = new Brand($id, $name);
       $test_brand->save($name);

       $id = 1;
       $name = "Footlocker";
       $test_store = new Store($id, $name);
       $test_store->save();

       //Act
       $test_brand->addStore($test_store);
       $result = $test_brand->getStores();

       //Assert
       $this->assertEquals([$test_store], $result);
   }

   function testGetStore()
   {
       //Arrange
       $id = 1;
       $name = "Vans";
       $test_brand = new Brand($id, $name);
       $test_brand->save($name);

       $id = 1;
       $name = "Footlocker";
       $test_store = new Store($id, $name);
       $test_store->save();

       $id = 4;
       $name2 = "Things for Feet";
       $test_store2 = new Store($id, $name2);
       $test_store2->save();

       //Act
       $test_brand->addStore($test_store);
       $test_brand->addStore($test_store2);
       $result = $test_brand->getStores();

       //Assert
       $this->assertEquals([$test_store, $test_store2], $result);
   }
}

?>
