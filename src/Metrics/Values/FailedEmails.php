<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class FailedEmails extends Value
{
    protected $event = 'failed';

    protected $uriKey = 'mailgun-failed-emails';
}
