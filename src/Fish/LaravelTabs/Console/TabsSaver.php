<?php

namespace Fish\LaravelTabs\Console;

interface TabsSaver {
  public function save($key, $parsed);
}
