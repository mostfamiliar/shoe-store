<?php
class Store {
      private $id;
      private $name;

      function __construct($id = null, $name)
      {
          $this->id = $id;
          $this->name = $name;
      }

      function setName($new_name)
      {
          $this->name = $new_name;
      }

      function getId()
      {
          return $this->id;
      }

      function getName()
      {
          return $this->name;
      }

      function save()
      {
          $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
          $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
        $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
        $stores = array();
        foreach ($returned_stores as $store)
        {
            $id = $store['id'];
            $name = $store['name'];
            $new_store = new Store($id, $name);
            array_push($stores, $new_store);
        }
        return $stores;
     }

     static function find($search_id)
     {
        $found_store = null;
        $stores = Store::getAll();

        foreach ($stores as $store)
        {
            $store_id = $store->getId();
            if ($store_id == $search_id)
            {
                $found_store = $store;
            }
        }
        return $found_store;
     }

     function update($new_name)
     {
         $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
         $this->setName($new_name);
     }

     function addBrand($brand)
     {
         $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
     }

     function getBrands()
     {
         $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN brands_stores ON (brands_stores.store_id = stores.id) JOIN brands ON (brands.id = brands_stores.brand_id) WHERE stores.id = {$this->getId()};");

         $brands = array();
         foreach($returned_brands as $brand)
         {
             $id = $brand['id'];
             $name = $brand['name'];
             $new_brand = new Brand($id, $name);
             array_push($brands, $new_brand);
         }
         return $brands;
     }

     function delete()
     {
         $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()}");
     }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM stores");
    }

}

?>
