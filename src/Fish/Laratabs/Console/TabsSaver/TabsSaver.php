<?php

namespace Fish\Laratabs\Console\TabsSaver;

interface TabsSaver {
  public function save($key, $parsed);
}
