<?php
namespace Fish\Laratabs\Models;

class Subtab extends \Eloquent  {

  protected $table = 'mfet_subtabs';

  protected $fillable = ['tab_id','name'];

  function tab() {
    return $this->belongsTo('Fish\Laratabs\Models\Tab');
  }

}
