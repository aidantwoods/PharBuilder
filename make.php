<?php

$dir = __DIR__;

echo `php $dir/src/bootstrap.php -d $dir/src/ -b $dir/src/bootstrap.php -o $dir/build/phar-build.phar  -vi`;
