<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'shift', 'wing', 'area'];

    public function employes()
    {
        return $this->belongsToMany(Employe::class, 'employe_order', 'order_id', 'employe_id');
    }

    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_order', 'equipment_id', 'order_id');
    }
}
