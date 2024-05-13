<?php
  namespace Framework;

  class Validation {
    /**
     * Validate string falls within a specified length range.
     * 
     * @param string $value 
     * @param int    $max
     * @param int    $min
     * 
     * @return bool;
     */
    public static function string($value, $min = 1, $max = INF) {
      if(is_string($value)) {
        $length = strlen(trim($value));
        return $length >= $min && $length <= $max;
      }
      return false;
    }

    /**
     * Validate SKU string consists of alphanumeric characters and within a valid regex
     * 
     * @param string $value 
     * @param int $min
     * @param int $max
     * 
     * @return bool;
     */
    public static function sku($value, $min = 1, $max = INF, $regex = "/^[a-zA-Z0-9]+$/") {
      return self::string($value, $min, $max) && preg_match($regex, $value);
    }

    /**
     * Validate a float value.
     * 
     * @param float $value 
     * @return bool
     */
    public static function float($value) {
      return filter_var(trim($value), FILTER_VALIDATE_FLOAT) && $value > 0;
    }

    /**
     * Sanitize by encoding special HTML characters.
     * 
     * @param array $data
     * @return array
     */
    public static function sanitize($data) {
      foreach ($data as &$value) {
        $value = strval(filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
      }
      return $data;
    }
  }