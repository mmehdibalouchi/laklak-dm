<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \Excel::load('storage/seeds/postsTags.xlsx', function($reader) {
        })->get();
        foreach($posts as $post)
        {
            $postSeeds[] = [
                "id"=>$post->get('id'),
                "user_id"=>$post->get('user_it'),
                "comment_count"=>$post->get('comment_count'),
                "type"=>$post->get('type'),
                "text"=>$post->get('text'),
//                "last_period"=>$post->get('last_period'),
                "id"=>$post->get('id'),
                "tag" => $post->get('tag'),
                'predefined_tag' =>$post->get('tag')!=null? true: false,
            ];
        }
        foreach ($postSeeds as $postSeed) {
//            $tag = null;
//            if($postSeed["tag"]!= null)
//                $tag = App\Tag::firstOrCreate(['title' => $postSeed["tag"]]);
//            unset($postSeed["tag"]);
            var_dump($postSeed["id"]);
            $post = App\Post::create($postSeed);
//            if(isset($tag))
//                $post->tags()->save($tag);
        }
    }
}
