<?php
/**
 * @file 
 */

namespace Turnfront\CurlRequest\Contracts;

interface CurlRequestInterface {

  public function makePost();

  public function setPostBody($body);

  public function setUrl($url);

  public function setOpt($option, $value);

  public function setHandler(ResponseInterface $response);

  public function send();

} 