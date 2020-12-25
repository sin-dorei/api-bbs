<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    public function updated(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}
