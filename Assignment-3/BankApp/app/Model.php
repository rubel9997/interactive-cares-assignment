<?php

declare(strict_types=1);

namespace App;

interface Model
{
    public static function getModelName(): string;
}