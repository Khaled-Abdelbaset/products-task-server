<?php

/**
 * Get the base path
 * 
 * @param string  $path
 * @return string
 */

  function basePath($path = "") {
    return __DIR__ ."/". $path;
  }

/**
 * Inspect Value(s)
 * 
 * @param mixed $value 
 * @return void
 */
function inspect($value ="") {
  if($value) {
    echo "<pre>";
    var_dump($value);
    echo"</pre>";
  } else {
    echo "Empty";
  }
}

/**
 * Inspect Value(s) And Die
 * 
 * @param mixed $value 
 * @return void
 */
function inspectAndDie($value = "") {
  if($value) {
    echo "<pre>";
    die(var_dump($value));
  } else {
    echo "Empty";
  }
}
