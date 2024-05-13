<?php
  namespace Framework;

  class Router {
    protected $routes = array();

    /**
     * Add new route
     * 
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action) {
      $arr = explode('@', $action);
      list($controller, $controllerMethod) = $arr;
      $this->routes[] = [
        "method" => $method,
        "uri"=> $uri,
        "controller"=> $controller,
        "controllerMethod" => $controllerMethod,
      ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller) {
      $this->registerRoute("GET", $uri, $controller);
    }
    
    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller) {
      $this->registerRoute("POST", $uri, $controller);
    }

    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller) {
      $this->registerRoute("PUT", $uri, $controller);
    }
  
    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller) {
      $this->registerRoute("DELETE", $uri, $controller);
    }

    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri) {
      $requestMethod = $_SERVER['REQUEST_METHOD'];
      foreach ($this->routes as $route) {
        if($route["uri"] === $uri && strtoupper($route["method"]) === $requestMethod) {
          $controller = "App\\Controllers\\{$route['controller']}";
          $controllerMethod = $route['controllerMethod'];
          
          // Instantiate the Controller
          $controllerInstance = new $controller();
          $controllerInstance->$controllerMethod();
          return;
        }
      }
      http_response_code(404);
      echo json_encode(array("error_message" => "this resource or page doesn't exist"));
    }
  }