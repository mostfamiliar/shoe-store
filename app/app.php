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
      return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/add_store", function() use ($app){
        $name = $_POST['name'];
        $formatted_name = preg_replace('/[ ](?=[ ])|[^-_,A-Za-z0-9 ]+/', '', $name);
        $store_name = ucfirst($formatted_name);
        $id = null;
        $new_store = new Store($id, $store_name);
        $new_store->save();
      return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("store/{id}/add_brand", function($id) use ($app){
        $store = Store::find($id);
        $name = $_POST['name'];
        $formatted_name = preg_replace('/[ ](?=[ ])|[^-_,A-Za-z0-9 ]+/', '', $name);
        $brand_name = ucfirst($formatted_name);
        $id = null;
        $new_brand = new Brand($id, $brand_name);
        $found_brand = $new_brand->save($brand_name);
        $error = "";
        if ($found_brand != null) {
            if (in_array($found_brand, $store->getBrands())){
                $error = "This brand already exists";
            }
            else {
            $store->addBrand($found_brand);
            }
        }
        else {
            $store->addBrand($new_brand);
        }

        $brands = $store->getBrands();
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $brands, 'error' => $error));
    });

    $app->post("brand/{id}/add_store", function($id) use ($app){
        $brand = Brand::find($id);
        $error = "";
        $store_id = (int) $_POST['id'];
        $store = Store::find($store_id);
        if (in_array($store, $brand->getStores())){
            $error = "This brand already exists";
        }
        else {
        $brand->addStore($store);
        }

        $stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $stores, 'all_stores' => $all_stores, 'error' => $error));
    });

    $app->post("/delete_all", function() use ($app){
     Store::deleteAll();
     return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/delete_brands", function() use ($app){
     Brand::deleteAll();
     return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
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

    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::Find($id);
        $stores = $brand->getStores();
        $all_stores = Store::getAll();
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $stores, 'all_stores' => $all_stores));
    });

    $app->patch("/store/{id}", function ($id) use ($app){
        $new_name = $_POST['new_name'];
        $store = Store::find($id);
        $store->update($new_name);
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->delete("/store/{id}", function ($id) use ($app){
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    return $app;
 ?>
