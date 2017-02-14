<?php

namespace Aidantwoods\PharBuild;

require_once('autoload.php');

(new Build((new Options)->get()))->run();
