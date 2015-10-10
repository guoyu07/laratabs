<?php
namespace Fish\Laratabs\Retriever;

/**
* Retrieves tabs data
*/

interface Retriever
{
  public function retrieve($key);
  public function getKeys($key = null);
}
