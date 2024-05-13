<?php
  namespace App\Models\ProductTypes;
  use App\Models\BaseProduct;

   /**
   * Constructor for DVD objects.
   * 
   * @param string $name 
   * @param string $sku
   * @param float  $price
   * @param string  $size
  */
  class Dvd extends BaseProduct {
    public function __construct($name, $sku, $price, $size) {
      parent::__construct($name, $sku, $price, 'dvd', "Size: $size");
    }
  }