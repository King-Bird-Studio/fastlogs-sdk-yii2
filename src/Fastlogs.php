<?php

namespace fastlogsYii;

use fastlogs\sdk\Sender;

class Fastlogs
{
    public static function add($data, $slug)
    {
        $sender = new Sender();
        $sender->add($data, $slug);
    }
}