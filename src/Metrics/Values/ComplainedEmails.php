<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class ComplainedEmails extends Value
{
    protected $event = 'complained';

    protected $uriKey = 'mailgun-complained-emails';
}
