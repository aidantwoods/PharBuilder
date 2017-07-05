<?php

namespace Aidantwoods\PharBuild;

class Options
{
    private $options,
            $requiredOptions = array('o', 'b'),
            $optionalOptions = array('d', 'f', 's'),
            $flags           = array('v', 'i');

    public function __construct()
    {
        $this->options = getopt(
            implode(':', $this->requiredOptions).':'
            . implode(':', $this->optionalOptions).':'
            . implode('', $this->flags)
        );

        $this->checkRequired();

    }

    private function checkRequired()
    {
        if (
            call_user_func(
                function() {
                    foreach ($this->requiredOptions as $option)
                    {
                        if ( ! array_key_exists($option, $this->options))
                        {
                            return true;
                        }
                    }

                    if ( ! isset($this->options['d']) and ! isset($this->options['f']))
                    {
                        return true;
                    }

                    return false;
                }
            )
        ) {
            die("Not enough options.\n\nUse `-o` for output package name, `-d` for directory or `-f` for a single file, and `-b` for bootstrap file\nOptionally use `-s` to specificy a directory name to skip, `-v` for verbose, `-i` to ignore dot files when adding via directory\n");
        }
    }

    public function get()
    {
        return $this->options;
    }
}
