<?php

namespace Fish\LaravelTabs\Models;


class Tab extends \Eloquent  {

  protected $table = 'mfet_tabs';

  protected $fillable = ['name'];

    function subtabs() {
    return $this->hasMany('Fish\LaravelTabs\Models\Subtab');
  }

    function key() {
    return $this->belongsTo('Fish\LaravelTabs\Models\Key');
  }
}
