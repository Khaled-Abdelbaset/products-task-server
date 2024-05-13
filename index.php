<?php
  // Include Composer's autoloader
  require __DIR__ ."/vendor/autoload.php";
  require "./helpers.php";

  use Framework\Router;
  $router = new Router();

  // Load routes from the routes.php file
  $routes = require basePath("routes.php");

  // Parse the request URI
  $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

  // Set CORS headers if the request originates from an allowed origin
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 1000');
  }

  // Handle preflight OPTIONS request for CORS
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
      header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
      header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
    }
    exit(0);
  }

  // Route the request using the Router
  $router->route($uri);
