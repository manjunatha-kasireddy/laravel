<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CmsPage;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsPageRecords = [
            [
                'id' => 1,
                'title' => 'About us',
                'description' => 'Content is comming soon',
                'url' => 'about-us',
                'meta_title' => 'About us',
                'meta_description' => 'About us Content',
                'meta_keywords' => 'about us,about',
                'status' => 1
            ],
            [
                'id' => 2,
                'title' => 'Terms & Condition',
                'description' => 'Content is comming soon',
                'url' => 'terms-condition',
                'meta_title' => 'Terms & Condition',
                'meta_description' => 'Terms & Condition Content',
                'meta_keywords' => 'terms,terms condition',
                'status' => 1
            ],
            [
                'id' => 3,
                'title' => 'Privacy Policy',
                'description' => 'Content is comming soon',
                'url' => 'privacy-policy',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Privacy Policy Content',
                'meta_keywords' => 'privacy policy',
                'status' => 1
            ],

        ];
        CmsPage::insert($cmsPageRecords);
    }
}