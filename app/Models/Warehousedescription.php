<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehousedescription extends Model
{
       
    protected $table = 'warehousedescriptions';
    
    protected $fillable = [
        'warehouse_id',
        'phone',
        'city',
        'address'
    ];
    
}
