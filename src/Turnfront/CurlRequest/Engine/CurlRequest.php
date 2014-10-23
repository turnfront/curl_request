<?php
/**
 * @file 
 */

namespace Turnfront\CurlRequest\Engine;


use Turnfront\CurlRequest\Contracts\CurlRequestInterface;
use Turnfront\CurlRequest\Contracts\ResponseInterface;

class CurlRequest implements CurlRequestInterface {
  /**
   * @var \Turnfront\Curlrequest\Contracts\ResponseInterface
   */
  protected $handler;

  protected $curlHandler = null;

  protected $opts = array();

  public function __construct(){
    $this->generateHandler();
  }

  public function makePost() {
    return $this->setOpt(CURLOPT_POST, 1);
  }

  public function setPostBody($body) {
    return $this->setOpt(CURLOPT_POSTFIELDS, $body);
  }

  public function setUrl($url) {
    return $this->setOpt(CURLOPT_URL, $url);
  }

  /**
   * Sets an arbitrary option on the current curl request.
   *
   * @param $option
   * @param $value
   *
   * @return $this
   */
  public function setOpt($option, $value) {
    $this->handlerWatchdog();
    curl_setopt($this->curlHandler, $option, $value);
    $this->opts[$option] = $value;
    return $this;
  }

  /**
   * The handler is an object that can receive the data extracted from the response of the remote server to the curl request.
   *
   * @param ResponseInterface $response
   *
   * @return $this
   */
  public function setHandler(ResponseInterface $response) {
    $this->handler = $response;
    return $this;
  }

  /**
   * Protect us from calling an empty curl handler, generates a new handler if none is found.
   *
   * @return bool
   */
  protected function handlerWatchdog(){
    if (!empty($this->curlHandler) && is_resource($this->curlHandler) && get_resource_type($this->curlHandler) === "curl"){
      return true;
    }
    $this->generateHandler();
    return true;
  }

  /**
   * Generates a new curl handler.
   */
  protected function generateHandler(){
    $this->curlHandler = curl_init();
    $this->opts = array();
  }

  /**
   * Send the cURL request.
   *
   * @return array|ResponseInterface
   */
  public function send() {
    $this->handlerWatchdog();
    curl_setopt($this->curlHandler, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($this->curlHandler, CURLOPT_CAINFO, dirname(__FILE__) . "/../../../../certs/cacert.pem");
    $result       = curl_exec($this->curlHandler);
    $responseInfo = curl_getinfo($this->curlHandler);
    if (!empty($this->opts[CURLOPT_RETURNTRANSFER])){
      $result = curl_multi_getcontent($this->curlHandler);
    }
    curl_close($this->curlHandler);
    if (isset($this->handler)){
      $this->handler->setResult($result);
      $this->handler->setResponseInfo($responseInfo);
      return $this->handler;
    }
    return array($result, $responseInfo);
  }
}