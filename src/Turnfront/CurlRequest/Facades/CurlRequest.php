<?php
/**
 * @file 
 */

namespace Turnfront\CurlRequest\Facades;

use Illuminate\Support\Facades\Facade;

class CurlRequest extends Facade {

  protected static function getFacadeAccessor() {
    return "Turnfront\\CurlRequest\\Contracts\\CurlRequestInterface";
  }

} 