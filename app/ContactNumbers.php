<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactNumbers extends Model
{
    public $timestamps = false;
    protected $table = 'contact_numbers';
    protected $primaryKey = 'id';
    protected $fillable = ['number', 'contact_id','number_type'];

}
