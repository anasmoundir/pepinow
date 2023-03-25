<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function plants()
    {
        return $this->belongsToMany(Product::class, 'categorie_plant');
    }
}
