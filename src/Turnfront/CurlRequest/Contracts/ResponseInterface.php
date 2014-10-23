<?php
/**
 * @file 
 */

namespace Turnfront\CurlRequest\Contracts;


interface ResponseInterface {

  public function setResponseInfo($responseInfo);

  public function setResult($result);

  public function getResult();

  /**
   * Return the status code of the request.
   *
   * @return int
   */
  public function getStatusCode();

} 