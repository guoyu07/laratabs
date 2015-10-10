<?php

namespace Fish\Laratabs\Models;


class Tab extends \Eloquent  {

  protected $table = 'mfet_tabs';

  protected $fillable = ['name'];

    function subtabs() {
    return $this->hasMany('Fish\Laratabs\Models\Subtab');
  }

    function key() {
    return $this->belongsTo('Fish\Laratabs\Models\Key');
  }
}
