<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    Use HasFactory;

    protected $fillable = ['firstName', 'lastName'];

    public function phoneNumbers()
    {
        return $this->hasMany(Phone::class);
    }
}
