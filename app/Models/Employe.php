<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = ['position_id', 'name', 'surname', 'addname', 'ekp_id'];

    public function scopeEmployeWithTag($query, $array_tag) {
        return $query->when($array_tag, function ($q) use ($array_tag) {
            $q->whereHas('tags', function ($q) use ($array_tag) {
                $q->whereIn('tag_id', $array_tag);
            });
        });
    }

    public function positions() {
        return $this->hasOne(Position::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'employe_tag', 'employe_id', 'tag_id');
    }

}
