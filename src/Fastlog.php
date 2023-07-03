<?php

namespace fastlog;

use fastlog\sdk\Sender;

class Fastlog
{
    public static function add($data, $slug)
    {
        $sender = new Sender();
        $sender->add($data, $slug);
    }
}