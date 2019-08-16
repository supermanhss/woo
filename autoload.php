<?php

class Loader
{
    public static function autoload($className)
    {
        $classArray = explode('\\', $className);

        $file_name = array_pop($classArray) . '.php';

        array_shift($classArray);
        $dir = implode(DIRECTORY_SEPARATOR, $classArray);

        $classFile = $dir . DIRECTORY_SEPARATOR . $file_name;

        if (is_file($classFile)) {
            include $classFile;
        }
    }
}
