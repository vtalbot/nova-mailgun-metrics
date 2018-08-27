<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class AcceptedEmails extends Value
{
    protected $event = 'accepted';

    protected $uriKey = 'mailgun-accepted-emails';
}
