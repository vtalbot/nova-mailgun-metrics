<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

class StoredEmails extends Value
{
    protected $event = 'stored';

    protected $uriKey = 'mailgun-stored-emails';
}
