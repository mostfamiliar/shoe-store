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
          $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}';)");
          $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
        $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
        $stores = array();
        foreach ($returned_stores as $store)
        {
            $id = $store['id'];
            $name = $store['store_name'];
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

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM stores");
    }

}

?>
