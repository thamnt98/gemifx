<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password',
        'phone_number',
        'application_type',
        'country',
        'state',
        'address',
        'zip_code',
        'city',
        'copy_of_id',
        'proof_of_address',
        'addtional_file',
        'ib_id',
        'check_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
