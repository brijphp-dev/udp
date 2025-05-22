<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chapter;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chapter::truncate();

        $chapterArray = [
            'USA Chapter',
            'UK Chapter',
            'Spain Chapter',
        ];

        foreach ($chapterArray as $key => $chapter) {
            Chapter::create([
                'chapter_name' => $chapter
            ]);
        }
    }
}
