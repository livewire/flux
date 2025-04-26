<?php

namespace Flux\Support;

class StrUtil
{
    public static function normalizeLineEndings($value)
    {
        return str_replace(["\r\n", "\r"], "\n", $value);
    }
}