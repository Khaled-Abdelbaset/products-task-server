<?php
  namespace App\Models;
  
  // Abstract class representing a product model.
  abstract class ProductModelAbstract {
    abstract public function create($productData);
    abstract public function show();
    abstract public function delete($deletedProducts);
  }