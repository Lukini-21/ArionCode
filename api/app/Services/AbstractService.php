<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 *
 */
abstract class AbstractService
{
    /**
     * @return array
     */
    abstract protected function getCacheTags(): array;

    /**
     * @return void
     */
    protected function clearCache(): void
    {
        Cache::tags($this->getCacheTags())->flush();
    }
}