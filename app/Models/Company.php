<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function admins()
    {
        return $this->hasMany(User::class, 'company_id')->hasRole('Admin');
    }
    public function members()
    {
        return $this->hasMany(User::class, 'company_id')->hasRole('Member');
    }
}
