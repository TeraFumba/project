<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    public $timestamps = false;
    protected $table = 'contacts';
    protected $with = ['ContactNumbers','emailAddresses'];
    protected $primaryKey = 'id';
    protected $fillable = ['l_name', 'f_name','id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * A contact can have Many contact Numbers
     */
    public function ContactNumbers()
    {
        return self::hasMany(ContactNumbers::class, 'contact_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * A contact can have Many Email Address
     */
    public function emailAddresses()
    {
        return self::hasMany(EmailAddresses::class, 'contact_id', 'id');
    }

}
