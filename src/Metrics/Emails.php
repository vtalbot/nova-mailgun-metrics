<?php

namespace TalbotNinja\NovaMailgun\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class Emails extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->result([
            'Group 1' => 100,
            'Group 2' => 200,
            'Group 3' => 300,
        ]);
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'emails';
    }
}
