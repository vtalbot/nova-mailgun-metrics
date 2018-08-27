<?php

namespace TalbotNinja\NovaMailgun\Metrics\Values;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value as NovaValue;
use Laravel\Nova\Metrics\ValueResult;
use TalbotNinja\NovaMailgun\Mailgun\MailgunStatistic;

abstract class Value extends NovaValue
{
    /** @var MailgunStatistic */
    protected $statistics;

    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->statistics = app(MailgunStatistic::class);
    }
    public function ofType(string $type): self
    {
        $this->statistics->ofType($type);

        return $this;
    }

    public function forDomain(string $domain): self
    {
        $this->statistics->forDomain($domain);

        return $this;
    }

    public function calculate(Request $request): ValueResult
    {
        $result = $this->statistics->fromTo($this->currentRange($request->get('range')))->get();
        $previous = $this->statistics->fromTo($this->previousRange($request->get('range')))->get();

        return $this->result($result)->previous($previous);
    }

    public function ranges(): array
    {
        return [
            30 => '30 Days',
            60 => '60 Days',
            90 => '90 Days',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
        ];
    }
}
