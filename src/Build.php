<?php

namespace Aidantwoods\PharBuild;

class Build
{
    private $directories    = array(),
            $files          = array(),
            $skip           = array(),
            $outputPhar,
            $bootstrap,
            $phar,
            $options;

    public function __construct(array $options)
    {
        $this->importOptions($options);
    }

    public function run()
    {
        if (is_file("$this->outputPhar"))
        {
            unlink("$this->outputPhar");
        }

        $this->phar = new \Phar(
            $this->outputPhar,

            \FilesystemIterator::CURRENT_AS_FILEINFO
            | \FilesystemIterator::KEY_AS_FILENAME
        );

        foreach ($this->directories as $dir)
        {
            $this->addDirectory($dir);
        }

        foreach ($this->files as $file)
        {
            $this->addFile($file);
        }

        $this->addFile($this->bootstrap);

        $name = basename($this->outputPhar, '.phar');

        $this->phar->setStub(
( ! isset($this->options['l']) ? "#!/usr/bin/env php\n" : '')
."<?php
Phar::mapPhar('{$name}');
set_include_path('phar://{$name}/' . get_include_path());
require('{$this->bootstrap}');
__HALT_COMPILER();"
        );

        // $this->phar->compressFiles(\Phar::GZ);
    }

    private function importOptions(array $options)
    {
        if (isset($options['d']))
        {
            if ( ! is_array($options['d']))
            {
                $options['d'] = array($options['d']);
            }

            foreach ($options['d'] as $key => $dir)
            {
                $options['d'][$key] = Directory::normalise($dir);
            }

            $this->directories = $options['d'];
        }

        if (isset($options['f']))
        {
            if ( ! is_array($options['f']))
            {
                $options['f'] = array($options['f']);
            }

            foreach ($options['f'] as $key => $file)
            {
                $options['f'][$key] = Directory::normalise($file);
            }

            $this->files = $options['f'];
        }

        $this->outputPhar = $options['o'];
        $this->bootstrap = $options['b'];

        if (isset($options['s']))
        {
            $this->skip = (is_array($options['s']) ? $options['s'] : array($options['s']));
        }

        $this->options = $options;
    }

    private function addDirectory($directory)
    {
        $directory = (string) $directory;

        $contents = scandir($directory);

        foreach ($contents as $item)
        {
            if ($item === '.' or $item === '..')
            {
                continue;
            }

            if (isset($this->options['i']) and $item[0] === '.')
            {
                continue;
            }

            $path = "$directory/$item";

            if (is_dir($path))
            {
                if (in_array($item, $this->skip, true))
                {
                    $this->output('Skipping '.$path);
                    continue;
                }

                $this->addDirectory($path);
                continue;
            }

            $this->addFile($path);
        }
    }

    private function addFile($path)
    {
        $this->output('Adding '.$path);

        $this->phar[$path] = file_get_contents(realpath($path));
    }

    private function output($text = '', $addNewline = true, $addCarriageReturn = false)
    {
        if (isset($this->options['v']))
        {
            echo ($addCarriageReturn ? "\r" : '')
                    . $text
                    . ($addNewline ? "\n" : '');
        }
    }
}
