<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class AcceptedEmails extends Value
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->statistics->forEvent('accepted');
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'mailgun-accepted-emails';
    }
}
