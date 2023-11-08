<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'address',
        'phone',
        // Add other fields as needed
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
