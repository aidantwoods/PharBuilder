<?php

namespace Aidantwoods\PharBuild;

class Directory
{
    public static function normalise($directory)
    {
        return preg_replace('/(?:[\/]|\s)+$/', '', $directory);
    }
}
