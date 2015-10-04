<?php
namespace Fish\LaravelTabs\Retriever;

/**
* Retrieves tabs data
*/

interface Retriever
{
  public function retrieve($key);
  public function getKeys($key = null);
}
