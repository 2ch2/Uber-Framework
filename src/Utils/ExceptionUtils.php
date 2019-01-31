<?php

namespace uber\Utils;

/**
 * Class, which contains some
 * utilities for Exceptions.
 *
 * Class ExceptionUtils
 *
 * @category Utilities
 *
 * @package uber\Utils
 *
 * @author Original Author <kamil.ubermade@gmail.com>
 *
 * @license The MIT License (MIT)
 *
 * @link https://github.com/kamil-ubermade/Uber-Framework
 */
class ExceptionUtils
{
    /**
     * Displays all of exception details.
     *
     * @param \Exception $exception
     */
    public static function displayFullExceptionDetails(\Exception $exception)
    {
        echo $exception->getMessage() . '<br>
            File: ' . $exception->getFile() . '<br>
            Line: ' . $exception->getLine() . '<br>
            Trace: ' . $exception->getTraceAsString();
    }

    /**
     * Displays only exception message.
     *
     * @param \Exception $exception
     */
    public static function displayExceptionMessage(\Exception $exception)
    {
        echo $exception->getMessage();
    }
}