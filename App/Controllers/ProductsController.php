<?php
  namespace app\Controllers;
  use Framework\Validation;
  use App\Models\ProductModel;
  use App\Models\ProductFactory;

  class ProductsController {
    /**
     * Controller action to retrieve and display all products.
     * 
     * @return void
    */
    public function show() {
      $product = new ProductModel();
      $result = $product->show();

      // Set HTTP response and send result
      http_response_code($result["response_code"]);
      echo json_encode($result);
    }

    /**
     * Validate data from user
     * 
     * @param array $data
     * @return array
    */
    public function validateData($data) {
      $data["name"] = Validation::string($data["name"]);
      $data["sku"] = Validation::sku($data["sku"]);
      $data["price"] = Validation::float($data["price"]);
      $data["type"] = Validation::string($data["type"]);
      $data["description"] = Validation::string($data["description"]);
      return $data;
    }

    /**
     * Controller action to create a new product
     *
     * @return void 
    */
    public function create() {
      // Read JSON Data From Request Body and Decode
      $json_data = file_get_contents('php://input');
      $productData = json_decode($json_data, true);
      
      // Validate All Data or return Error Message
      $validationResult = $this->validateData($productData);

      // Check for validation errors
      $errors = [];
      foreach ($validationResult as $key => $result) {
        if (!$result) {
          $errors[$key] = "Product {$key} must have valid data";
        }
      }

      // Return error response if there are validation errors
      if (!empty($errors)) {
        http_response_code(400);
        $result = ["error_message" => "Validation failed", "errors" => $errors];
        echo json_encode($result);
        exit;
      }

      // Sanitize by Encoding Special HTML Characters
      $productData = Validation::sanitize($productData);

      // Use ProductFactory to create a product instance based on the provided data
      $product = ProductFactory::createProduct(
        $productData["type"], 
        $productData["name"],
        "{$productData["type"]}-{$productData["sku"]}",
        $productData["price"],
        $productData["description"]
      );

      // Create a new product object
      $createProduct = new ProductModel();

      // Call the create method of the product object to create the product
      $result = $createProduct->create($product);

      // Set HTTP response and send result
      http_response_code($result["response_code"]);
      echo json_encode($result);
    }

    /**
     * Controller action to delete products
     * 
     * @return void
    */
    public function delete() {
      // Read JSON Data From Request Body and Decode
      $json_data = file_get_contents('php://input');
      $deletedProducts = json_decode($json_data, true);
      
      $product = new ProductModel();
      $result = $product->delete($deletedProducts);

      // Set HTTP response and send result
      http_response_code($result["response_code"]);
      echo json_encode($result);
    }
  }
