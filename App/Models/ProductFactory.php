<?php
  namespace App\Models;

  class ProductFactory {
   /**
   * Creates a product object based on the provided type.
   * 
   * @param string $type
   * @param string $name
   * @param string $sku
   * @param float  $price
   * @param string $description
   * 
   * @return mixed|null
  */
    public static function createProduct($type, $name, $sku, $price, $description) {
      $type = ucfirst(strtolower($type));
      $className = "App\Models\ProductTypes\\{$type}";
      return new $className($name, $sku, $price, $description);
    }
  }