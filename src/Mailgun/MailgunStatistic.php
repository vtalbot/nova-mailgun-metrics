<?php

namespace TalbotNinja\NovaMailgun\Mailgun;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Mailgun\Mailgun;
use Mailgun\Model\Stats\TotalResponseItem;

class MailgunStatistic
{
    /** @var Carbon */
    protected $end;

    /** @var string */
    protected $event;

    /** @var string */
    protected $domain;

    /** @var Mailgun */
    protected $mailgun;

    /** @var Carbon */
    protected $start;

    /** @var string */
    protected $type;

    public function __construct(Mailgun $mailgun, string $domain)
    {
        $this->mailgun = $mailgun;
        $this->domain = $domain;
    }

    public function all(): self
    {
        $this->type = 'total';

        return $this;
    }

    public function forDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function forEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function from(Carbon $date): self
    {
        $this->start = $date;

        return $this;
    }

    public function fromTo(array $range)
    {
        [$from, $end] = $range;

        return $this->from($from)->to($end);
    }

    public function ofType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function to(Carbon $date): self
    {
        $this->end = $date;

        return $this;
    }

    /** @return TotalResponseItem[] */
    public function get(): array
    {
        $results = $this->mailgun->stats()->total($this->domain, [
            'event' => $this->event,
            'start' => $this->start->timestamp,
            'end' => $this->end->timestamp,
        ]);

        return $results->getStats();
    }

    public function associatedDateValue()
    {
        return Collection::make($this->get())->mapWithKeys(function (TotalResponseItem $item) {
            return [$item->getTime()->format('M j') => Collection::make($item->getAccepted())->sum($this->type)];
        })->all();
    }

    public function sum(): int
    {
        return Collection::make($this->get())->sum("{$this->event}.{$this->type}");
    }
}
