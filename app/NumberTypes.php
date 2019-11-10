<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberTypes extends Model
{
    public $timestamps = false;
    protected $table = 'contact_number_type';
    protected $primaryKey = 'id';
    protected $fillable = ['label'];
}
