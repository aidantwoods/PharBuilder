<?php

namespace Aidantwoods\PharBuilder;

if (is_file(__DIR__.'/../vendor/autoload.php'))
{
    require_once(__DIR__.'/../vendor/autoload.php');
}

(new Build((new Options)->get()))->run();
