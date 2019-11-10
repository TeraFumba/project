<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailAddresses extends Model
{
    public $timestamps = false;
    protected $table = 'email_addresses';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'created_at','updated_at', 'contact_id'];
}
