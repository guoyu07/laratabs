<?php

namespace Fish\LaravelTabs\Models;

class Tab extends Eloquent  {

  protected $table = 'mfet_tabs';

  protected $fillable = ['name'];

    function subtabs() {
    return $this->hasMany('Subtab');
  }

    function key() {
    return $this->belongsTo('Key');
  }
}
