<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App;

class Page extends Model
{
    use HasFactory;

    protected $with = ['page_localizations'];

     
    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? App::getLocale() : $lang_key;
        $page_localizations = $this->page_localizations->where('lang_key', $lang_key)->first();
        return $page_localizations != null && $page_localizations->$entity ? $page_localizations->$entity : $this->$entity;
    }

    public function page_localizations()
    {
        return $this->hasMany(PageLocalization::class);
    } 
}
