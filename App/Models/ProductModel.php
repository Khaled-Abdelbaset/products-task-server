<?php
  namespace App\Models;

  use App\Models\ProductModelAbstract;
  use Framework\Database;
  use PDOException;

  class ProductModel extends ProductModelAbstract {
    private $table = "products"; 
    private $db;

    /**
     * Constructor function to initialize the database connection.
     * 
     * @return void
    */
    public function __construct() {
      $config = require basePath("Config/DB.php");
      $this->db = new Database($config);
    }

    /**
     * Retrieves all products from the database.
     *
     * @return array
     * 
     * @throws PDOException
    */
    public function show() {
      try {
        $query = "SELECT * FROM {$this->table} ORDER BY id";
        $stmt = $this->db->query($query);

        // Handle query execution error
        if ($stmt instanceof PDOException) {
          throw new PDOException($stmt->getMessage());
        }

        // Query excuted successfully
        $allProducts = $stmt->fetchAll();
        return array("all_products" => $allProducts, "response_code" => 200 );

      } catch (PDOException $e) {
        // Handle database errors
        return array("error_message" => "Database error: {$e->getMessage()}", "response_code" => 500);
      }
    }

    /**
     * Create new product in the database
     * 
     * @param object $product
     * @return array
    */
    public function create($product) {
      $productData = $this->extractProductData($product) ;
      try {
        // Check for duplicated SKU value
        if ($this->isDuplicateSKU($productData["sku"])) {
          return ["duplicated_error" => "Duplicated value, SKU must be unique", "response_code" => 409];
        }

        // Insert data into the database
        $insertedRows = $this->insertProductData($productData);

        if (!$insertedRows) {
          throw new PDOException("Data insertion failed");
        }

        // Data inserted successfully
        return array("success_message" => "Data inserted successfully", "response_code" => 200);

      } catch (PDOException $e) {
        // Handle database errors
        return array("error_message" => "Database error: {$e->getMessage()}", "response_code" => 500);
      }
    }

    /**
     * Inserts product data into the database.
     *
     * @param array $productData
     * @return int
     *
     * @throws PDOException
    */
    private function insertProductData($productData) {
      $fields = implode(", ", array_keys($productData));
      $valuesPlaceholder = ":".implode(", :", array_keys($productData));
  
      $query = "INSERT INTO {$this->table} ($fields) VALUES ($valuesPlaceholder)";
      return $this->db->query($query, $productData)->rowCount();
    }

    /**
     * Checks if a SKU already exists in the database.
     *
     * @param string $sku
     * @return bool
     * 
     * @throws PDOException
    */
    private function isDuplicateSKU($sku) {
      $query = "SELECT COUNT(*) FROM {$this->table} WHERE sku = :sku";
      $stmt = $this->db->query($query, ["sku" => $sku]);
  
      if ($stmt instanceof PDOException) {
        throw new PDOException($stmt->getMessage());
      }
      return $stmt->fetchColumn() > 0;
    }

    /**
     * Extract product data from product object.
     *
     * @param object $product 
     * @return array
    */
    private function extractProductData($product) {
      return [
        "name" => $product->__get("name"),
        "sku" => $product->__get("sku"),
        "price" => $product->__get("price"),
        "type" => $product->__get("type"),
        "description" => $product->__get("description"),
      ];
    }

    /**
     * Delete Products from provided list of products.
     *
     * @param array $deletedProducts
     * @return array
     * 
     * @throws PDOException
    */
    public function delete($deletedProducts) {
      $valuesPlaceholder = ":".implode(", :", array_keys($deletedProducts));

      try {
        $query = "DELETE FROM {$this->table} WHERE id IN ({$valuesPlaceholder})";
        $stmt = $this->db->query($query, $deletedProducts);

        $deleteResult = $stmt->rowCount();

        // Handle data deletion failure
        if (!$deleteResult) {
          throw new PDOException("Data deletion failed");
        }
  
        // Data deleted successfully
        return array("success_message" => "Data deleted successfully", "response_code" => 200);

      } catch(PDOException $e) {
        // Handle database errors
        return array("error_message" => "Database error: {$e->getMessage()}", "response_code" => 500);
      }
    }
  }