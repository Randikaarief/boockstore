<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name' => 'Fiction'],
            ['name' => 'Science Fiction'],
            ['name' => 'Fantasy'],
            ['name' => 'Mystery'],
            ['name' => 'Thriller'],
            ['name' => 'Horror'],
            ['name' => 'Romance'],
            ['name' => 'Non-Fiction'],
            ['name' => 'Biography'],
            ['name' => 'History'],
            ['name' => 'Science'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}