<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'stock',
        'cover_image',
    ];

    /**
     * The genres that belong to the book.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * Get the order items for the book.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
