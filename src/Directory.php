<?php

namespace Aidantwoods\PharBuilder;

class Directory
{
    public static function normalise($directory)
    {
        return preg_replace('/(?:[\/]|\s)+$/', '', $directory);
    }
}
