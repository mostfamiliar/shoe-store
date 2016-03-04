<?php
    class Brand {

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

        function save($new_name)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM brands WHERE name = '{$new_name}';");
            $brand_match = $query->fetchAll(PDO::FETCH_ASSOC);
            $found_brand = null;
            foreach ($brand_match as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $found_brand = Brand::find($id);
            }
            if ($found_brand != null) {
                return $found_brand;
            }
            else {
                $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
            }

        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
            $brands = array();

            foreach ($returned_brands as $brand)
            {
                $id = $brand['id'];
                $name = $brand['name'];
                $new_brand = new Brand($id, $name);
                array_push($brands, $new_brand);
            }

            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands");
        }

        static function find($search_id)
        {
            $found_brand = "";
            $brands = Brand::getAll();

            foreach($brands as $brand)
            {
                $brand_id = $brand->getId();
                if ($brand_id = $search_id)
                {
                    $found_brand = $brand;
                }
            }

            return $found_brand;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name '{$new_name}' WHERE id = {$this->getId()}");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()}");
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands_stores.brand_id = brands.id) JOIN stores ON (stores.id = brands_stores.store_id) WHERE brands.id = {$this->getId()};");

            $stores = array();
            foreach($returned_stores as $store)
            {
                $id = $store['id'];
                $name = $store['name'];
                $new_store = new Store($id, $name);
                array_push($stores, $new_store);
            }

            return $stores;
        }
    }


 ?>
