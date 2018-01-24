<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DataMiningController extends Controller
{

    public function index()
    {
        $posts = Post::all();
//        $target = Post::find('135419');
        $dp=[];
        $result = [];
        $i = 0;
        foreach ($posts as $target) {
            $maxCos = 0;
            if($target->tag == null) {
                foreach ($posts as $post) {
                    if ($target->id != $post->id && $post->predefined_tag == true) {
                        if (isset($dp[$post->id][$target->id])) {
                            $dp[$target->id][$post->id] = $dp[$post->id][$target->id];

                        } else
                            $dp[$target->id][$post->id] = $this->cosDistance($target, $post);
//                    if($this->cosDistance($target, $post) >= $maxCos)
//                        $result[$target->id] = $post->id;
                    }
                }
                $target->tag = Post::find(array_keys($dp[$target->id], max($dp[$target->id]))[0])->tag;
                $target->save();
            }
//            var_dump($target->id);
//            $result[$target->id] = Post::find(array_keys($dp[$target->id], max($dp[$target->id]))[0]);
//            $result[$target->id] = array_keys($dp[$target->id], max($dp[$target->id]))[0];
//            dd($target->text);
            $i++;
        }
        dd($dp);
//        dd(array_keys($cosdises, max($cosdises)));
//        var_dump($target->text);
        $result = Post::find('134021');
        var_dump($target->text);
        var_dump($result->text);
    }
    private function cosDistance($first, $second)
    {
        $first = explode(" ", $this->stringMapping($first));
        $second = explode(" ", $this->stringMapping($second));
        $vector = [];
        foreach ($first as $item) {
            if(!in_array(trim($item), $vector))
                $vector[] = trim($item);
        }
        foreach ($second as $item) {
            if(!in_array(trim($item), $vector))
                $vector[] = trim($item);
        }
        $first = array_count_values($first);
        $second = array_count_values($second);
        foreach ($vector as $item)
        {
            $v1[] = array_key_exists($item, $first)? $first[$item]: 0;
            $v2[] = array_key_exists($item, $second)? $second[$item]: 0;
        }
        $dot = 0;
        $v1size = 0;
        $v2size = 0;

        for ($i = 0; $i<sizeof($vector); $i++)
        {
            $dot += ($v1[$i] * $v2[$i]);
            $v1size+= pow($v1[$i], 2);
            $v2size+= pow($v2[$i], 2);
        }
        $v1size = pow($v1size, 1/2);
        $v2size = pow($v2size, 1/2);
        return ($dot/($v1size*$v2size));
    }
    private function stringMapping($string)
    {
        $raw = ["٠", "۱", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩", "۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", "ئ", "ي", "ء", "أ", "إ", "ٱ", "ة", "ؤ", "ك", "ۀ", "‌ "];
        $final = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1" , "2", "3", "4", "5", "6", "7", "8", "9", "ی", "ی", "ی", "ا", "ا", "ا", "ه", "و", "ک", "ە ی", " " ];
        $converted =  str_replace($raw, $final, $string);
        return $converted;
    }
}
