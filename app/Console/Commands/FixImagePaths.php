<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixImagePaths extends Command
{
    protected $signature = 'fix:image-paths';
    protected $description = 'Remove duplicate storage/ prefix from image paths in database';

    public function handle()
    {
        // Fix banner_image
        $banners = DB::table('rentable_projects')
            ->where('banner_image', 'LIKE', 'storage/%')
            ->update(['banner_image' => DB::raw("REPLACE(banner_image, 'storage/', '')")]);

        // Fix media_images (JSON column)
        $media = DB::table('rentable_projects')
            ->where('media_images', 'LIKE', '%storage/%')
            ->update(['media_images' => DB::raw("REPLACE(media_images, 'storage\\/', '')")]);

        // Fix profile photos
        $photos = DB::table('users')
            ->where('profile_photo_path', 'LIKE', 'storage/%')
            ->update(['profile_photo_path' => DB::raw("REPLACE(profile_photo_path, 'storage/', '')")]);

        $this->info("Fixed: {$banners} banner(s), {$media} media record(s), {$photos} profile photo(s)");
    }
}
