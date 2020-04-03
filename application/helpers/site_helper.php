<?php

if(!function_exists('cloudServiceURL')) {
  function cloudServiceURL() {

    if ($_SERVER["HTTP_HOST"] == 'localhost') {
      return ("http://localhost:9900");
    } else {
      return ("https://clouds.onecloudops.com:9900");
    }
    
  }
}