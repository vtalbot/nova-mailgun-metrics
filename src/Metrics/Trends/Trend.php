<?php

namespace TalbotNinja\NovaMailgun\Metrics\Trends;

use Laravel\Nova\Metrics\Trend as NovaTrend;
use TalbotNinja\NovaMailgun\Mailgun\MailgunStatistic;

abstract class Trend extends NovaTrend
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->statistics = app(MailgunStatistic::class);
    }
}
