<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class DeliveredEmails extends Value
{
    protected $event = 'delivered';

    protected $uriKey = 'mailgun-delivered-emails';
}
