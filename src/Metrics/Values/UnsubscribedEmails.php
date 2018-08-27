<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class UnsubscribedEmails extends Value
{
    protected $event = 'unsubscribed';

    protected $uriKey = 'mailgun-unsubscribed-emails';
}
