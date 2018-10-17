<?php

use Illuminate\Database\Seeder;
use App\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic2 = ['title' => 'Angular'];
        $topic3 = ['title' => 'NodeJS'];
        $topic4 = ['title' => 'CSS'];
        $topic5 = ['title' => 'Python'];
        $topic6 = ['title' => 'C++'];


        Topic::create($topic2);
        Topic::create($topic3);
        Topic::create($topic4);
        Topic::create($topic5);
        Topic::create($topic6);
    }
}
