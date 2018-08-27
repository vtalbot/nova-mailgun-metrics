<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class OpenedEmails extends Value
{
    protected $event = 'opened';

    protected $uriKey = 'mailgun-opened-emails';
}
