<?php
/**
 * Created by cuongpm/modularization.
 * Date: 8/11/19
 * Time: 12:34 AM
 */

namespace Modularization\src\Helpers;


use Illuminate\Support\Str;

class BuildInput
{
    public static function name($table)
    {
        return ucfirst(Str::camel(Str::singular($table)));
    }

    public static function route($table)
    {
        return Str::kebab(Str::camel($table));
    }

    public static function classe($table)
    {
        return ucfirst(Str::singular(Str::camel($table)));
    }
}