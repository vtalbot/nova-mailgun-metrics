<?php

namespace TalbotNinja\NovaMailgun\Metrics\Trends;

class AcceptedEmailsPerDay extends Trend
{
    protected $event = 'accepted';

    protected $uriKey = 'mailgun-accepted-emails-per-day';
}
