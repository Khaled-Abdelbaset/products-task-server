<?php
  namespace App\Models;

  interface ProductInterface {
    public function __get($property);
    // public function getSKU(): string;
    // public function getName(): string;
    // public function getPrice(): float;
    // public function getType(): string;
    // public function getTypeAttribute(): string;
}