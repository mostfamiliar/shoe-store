<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";


    // session_start();

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../views"
    ));

    $app->get("/", function() use ($app){
      return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/add_store", function() use ($app){
        $store_name = $_POST['name'];
        $id = null;
        $new_store = new Store($id, $store_name);
        $new_store->save();
      return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/delete_all", function() use ($app){
        Store::deleteAll();
     return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    return $app;
 ?>
