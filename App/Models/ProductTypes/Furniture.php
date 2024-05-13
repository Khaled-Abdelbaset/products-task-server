<?php
  namespace App\Models\ProductTypes;
  use App\Models\BaseProduct;

  /**
   * Constructor for Furniture objects.
   * 
   * @param string $name
   * @param string $sku
   * @param float  $price
   * @param string $dimensions
  */
  class Furniture extends BaseProduct{
  public function __construct($name, $sku, $price, $dimensions) {
      parent::__construct($name, $sku, $price, 'furniture', "Dimensions: $dimensions");
    }
  }
