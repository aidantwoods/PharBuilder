# PharBuilder

## Example:
`-o` output to

`-d` add a directory

`-b` bootstrap file

`-v` verbose

`-i` ignore dot files

```bash
php src/bootstrap.php -o build/phar-build.phar -d src/ -b src/bootstrap.php -vi
```

## Output:
```
Adding src/Build.php
Adding src/Directory.php
Adding src/Options.php
Adding src/autoload.php
Adding src/bootstrap.php
```