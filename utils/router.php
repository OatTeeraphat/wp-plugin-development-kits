<?php

class WPPDK_ROUTER {
  
    // Methods
    function register($path, $view) {
        if ( strpos ($_SERVER['REQUEST_URI'], $path) !== false ) {
            return $view;
        }
    }
    
  }