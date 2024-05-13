<?php
  $router->get("/products", "ProductsController@show");
  $router->post("/products", "ProductsController@create");
  $router->delete("/products", "ProductsController@delete");
