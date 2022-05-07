<?php

namespace App\View\Fields;

use Illuminate\Support\Arr;

class Repository extends \Orchid\Screen\Repository
{
    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getContent(string $key, $default = null)
    {
        $path = '';
        $segments = explode('.', $key);

        foreach ($segments as $index => $segment) {
            if (str_contains($segment, '[]')) {
                $rawSegment = str_replace('[]', '', $segment);

                return Arr::get($this->items, $path . '.' . $rawSegment);
            }
            $path .= $segment;
        }

        return Arr::get($this->items, $key, $default);
    }
}
