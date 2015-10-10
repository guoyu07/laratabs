<?php

namespace Fish\Laratabs\Console;

interface TabsSaver {
  public function save($key, $parsed);
}
