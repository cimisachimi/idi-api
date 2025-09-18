<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Note: This seeder uses placeholder image paths.
     * For these seeds to display correctly in your frontend,
     * you must place corresponding images in the `storage/app/public/galleries/` directory
     * and ensure you have run `php artisan storage:link`.
     */
    public function run(): void
    {
        DB::table('galleries')->insert([
            [
                'title' => 'Beautiful Landscape',
                'image_path' => 'galleries/sample1.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'City at Night',
                'image_path' => 'galleries/sample2.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Abstract Art',
                'image_path' => 'galleries/sample3.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}