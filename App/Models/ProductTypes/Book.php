<?php
  namespace App\Models\ProductTypes;
  use App\Models\BaseProduct;

  /**
   * Constructor for Book objects.
   * 
   * @param string $name
   * @param string $sku
   * @param float  $price
   * @param string $weight
  */
  class Book extends BaseProduct{
    public function __construct($name, $sku, $price, $weight) {
      parent::__construct($name, $sku, $price, 'book', "Weight: $weight");
    }
  }