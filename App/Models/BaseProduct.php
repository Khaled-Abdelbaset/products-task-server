<?php
  namespace App\Models;
  use App\Models\ProductInterface;

  abstract class BaseProduct implements ProductInterface {
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $description;

    /**
     * Constructor to initialize properties of the product.
     * 
     * @param string $name 
     * @param string $sku
     * @param float  $price
     * @param string $type
     * @param string $description
    */
    public function __construct($name, $sku, $price, $type, $description) {
      $this->sku = $sku;
      $this->name = $name;
      $this->price = $price;
      $this->type = $type;
      $this->description = $description;
    }

    /**
     * Magic method to dynamically retrieve properties of the product.
     * 
     * @param string $property
     * 
     * @return mixed|null
     */
    public function __get($property) {
      if(property_exists($this, $property)) {
        return $this->$property;
      }
    }
  }