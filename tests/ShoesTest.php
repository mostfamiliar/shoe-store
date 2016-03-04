<?php

// //if using database
// /**
// * @backupGlobals disabled
// * @backupStaticAttributes disabled
// */

require_once "src/Shoe.php";

//if using database
$server = 'mysql:host=localhost;dbname=shoes_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);



class  ShoeTest  extends PHPUnit_Framework_TestCase{

    protected function tearDown()
    {
       Shoe::deleteAll();
    }

    
}
?>
