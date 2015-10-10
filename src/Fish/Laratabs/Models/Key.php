<?php
namespace Fish\Laratabs\Models;


class Key extends \Eloquent  {

  protected $table = 'mfet_keys';

  protected $fillable = ['name'];

    function tabs() {
     return $this->hasMany('Fish\Laratabs\Models\Tab');
  }
}
