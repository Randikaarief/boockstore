<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * The books that belong to the genre.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
