<?php
namespace Fish\LaravelTabs\Retriever;

use Fish\LaravelTabs\Models\Key;
use DB;
use Fish\LaravelTabs\HTML\Exceptions\UndefinedKeyException;

/**
* Retrieve tabs from Database
*/

class DatabaseRetriever implements Retriever
{

  public function retrieve($key)
  {

      $tabs = [];
      $result = [];

      $data = Key::where('key',$key)
      ->first();

      if (!$data)
        throw new UndefinedKeyException("The key '{$key}' doesn't exist");

      $data = $data->tabs()
      ->with('subtabs')
      ->get()
      ->toArray();

      if (!$data) return false;

      foreach ($data as $index=>$maintab):
        $result[$index]['tab'] = $maintab['name'];
        foreach ($maintab['subtabs'] as $subtab):
          $result[$index]['subtabs'][] = $subtab['name'];
        endforeach;
      endforeach;

      return $result;
  }

  public function getKeys($key = null) {
    if ($key):
      $keys = Key::where('key',$key)->first();
      $keys = $keys?[$keys->key]:null;
    else:
       $keys = Key::lists('key');
    endif;

    return $keys;
  }

}
