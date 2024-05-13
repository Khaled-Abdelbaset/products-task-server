<?php

  namespace Framework;
  use PDO, PDOException, Exception, PDOStatement;

  class Database {
    public $conn;

    /**
     * Constructor for databse class
     * 
     * @param array $config
     */
    public function __construct($config) {
      // Construct the DSN for PDO based on the provided configuration
      $dsn = "{$config["dbdriver"]}:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

      // Set PDO options for error handling and fetch mode
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ];
      try {
        $this->conn = new PDO($dsn, $config["username"], $config["password"], $options);
      } catch (PDOException $e) {
        throw new Exception("Failed To Connect To Databse: {$e->getMessage()}");
      }
    }

    /**
     * Query The Database
     * 
     * @param string $query
     * @param array  $params
     * 
     * @return mixed
     */
    public function query($query, $params = []) {
      try {
        $stmt = $this->conn->prepare($query);
        foreach ($params as $param => $value) {
          $stmt->bindValue(":{$param}", $value);
        }
        $stmt->execute();
        return $stmt;
      } catch (PDOException $error) {
        return $error;
      }
    }
  }