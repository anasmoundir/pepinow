<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;
   
    protected $table = 'plants';
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'image',
    ];
    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'categorie_plant');
    }
}
