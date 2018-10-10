<?php
/**
 * Created by PhpStorm.
 * User: Bole
 * Date: 28.9.2018
 * Time: 16:54
 */

namespace App\Traits;


trait Helper
{
    public function shortenText($word_count){

        $text=$this->body;
        if(str_word_count($this->body, 0)> $word_count){

            $words=str_word_count($this->body, 2);
            $pos=array_keys($words);
            $text=substr($this->body, 0, $pos[$word_count]).'...';
        }
        return $text;
    }

    public function showDate($time=null){
        return $time ? $this->updated_at->format('d.m.Y @ H:i:s') :$this->updated_at->format('d.m.Y') ;
    }
}