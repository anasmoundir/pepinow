<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
    ];
    public function plants()
    {
        return $this->belongsToMany(Plant::class, 'categorie_plant');
    }
}
