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

    // protected function tearDown()
    // {
    //    Brand::deleteAll();
    // }

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
}

?>
