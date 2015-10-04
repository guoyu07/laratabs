<?php

namespace Fish\LaravelTabs\Console\TabsSaver;

interface TabsSaver {
  public function save($key, $parsed);
}
