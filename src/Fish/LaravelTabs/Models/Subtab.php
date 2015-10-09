<?php
namespace Fish\LaravelTabs\Models;

class Subtab extends \Eloquent  {

  protected $table = 'mfet_subtabs';

  protected $fillable = ['tab_id','name'];

  function tab() {
    return $this->belongsTo('Fish\LaravelTabs\Models\Tab');
  }

}
