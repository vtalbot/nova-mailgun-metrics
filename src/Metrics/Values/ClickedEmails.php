<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class ClickedEmails extends Value
{
    protected $event = 'clicked';

    protected $uriKey = 'mailgun-clicked-emails';
}
