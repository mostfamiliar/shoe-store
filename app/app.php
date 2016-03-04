<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    $app->post("store/{id}/add_brand", function($id) use ($app){
        $store = Store::find($id);

        $brand_name = $_POST['name'];
        $id = null;
        $new_brand = new Brand($id, $brand_name);
        $new_brand->save();

        $store->addBrand($new_brand);
        $brands = $store->getBrands();

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $brands));
    });

    $app->post("/delete_all", function() use ($app){
        Store::deleteAll();
     return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/store/{id}", function($id) use ($app){
        $store = Store::Find($id);
        $brands = $store->getBrands();

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $brands));
    });

    $app->get("/store/{id}/edit", function($id) use ($app){
        $store = Store::Find($id);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store));
    });

    $app->patch("/store/{id}", function ($id) use ($app){
        $new_name = $_POST['new_name'];
        $store = Store::find($id);
        $store->update($new_name);
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->delete("/store/{id}", function ($id) use ($app){
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    return $app;
 ?>
