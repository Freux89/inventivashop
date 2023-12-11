<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
    ];

    protected $with = ['state_localizations'];

    public function newQuery()
    {
        return parent::newQuery()->orderBy('position', 'asc');
    }

    public function state_localizations()
    {
        return $this->hasMany(StateLocalization::class);
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {
        $lang_key = $lang_key ==  '' ? app()->getLocale() : $lang_key;
        $state_localizations = $this->state_localizations->where('lang_key', $lang_key)->first();
        return $state_localizations != null && $state_localizations->$entity ? $state_localizations->$entity : $this->$entity;
    }


}
