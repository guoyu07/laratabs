<?php
namespace Fish\LaravelTabs\Models;
class Key extends Eloquent  {

  protected $table = 'mfet_keys';

  protected $fillable = ['name'];

    function tabs() {
     return $this->hasMany(new Tab);
  }
}
