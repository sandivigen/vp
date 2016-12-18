<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('articles')->insert([
            [
                'category' => 'Samodelky',
                'title' => str_random(10),
                'user_id' => 1,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1, tag-2',
            ],
            [
                'category' => 'Progulka',
                'title' => str_random(10),
                'user_id' => 2,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1, tag-3',
            ],
            [
                'category' => 'Other',
                'title' => str_random(10),
                'user_id' => 3,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1, tag-2, tag-3',
            ],
            [
                'category' => 'Progulka',
                'title' => str_random(10),
                'user_id' => 1,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-3',
            ],
            [
                'category' => 'Samodelky',
                'title' => str_random(10),
                'user_id' => 2,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-3',
            ],
            [
                'category' => 'Progulka',
                'title' => str_random(10),
                'user_id' => 3,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1',
            ],
            [
                'category' => 'Samodelky',
                'title' => str_random(10),
                'user_id' => 1,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1, tag-2, tag-3',
            ],
            [
                'category' => 'Progulka',
                'title' => str_random(10),
                'user_id' => 2,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-2, tag-3',
            ],
            [
                'category' => 'Samodelky',
                'title' => str_random(10),
                'user_id' => 3,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1',
            ],
            [
                'category' => 'Other',
                'title' => str_random(10),
                'user_id' => 1,
                'thumbnail' => 'http://'.str_random(10).'.jpg',
                'text' => str_random(300),
                'video_id' => str_random(10),
                'start_video' => 'none',
                'tags' => 'tag-1, tag-2, tag-3',
            ],
        ]);

    }
}
