<?php

namespace App\Models;

use App\Models\User;
use App\Models\Breed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->morphedByMany(User::class, 'parkable');
    }

    public function breeds()
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }
}
