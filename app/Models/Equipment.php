<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = ['title', 'additional_title', 'asd_code', 'position'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'equipment_order', 'order_id', 'equipment_id');
    }
}
