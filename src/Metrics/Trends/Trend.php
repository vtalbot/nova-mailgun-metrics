<?php

namespace TalbotNinja\NovaMailgun\Metrics\Trends;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend as NovaTrend;
use Laravel\Nova\Metrics\TrendResult;
use TalbotNinja\NovaMailgun\Mailgun\MailgunStatistic;

abstract class Trend extends NovaTrend
{
    /** @var MailgunStatistic */
    protected $statistics;

    /** @var string */
    protected $uriKey;

    /** @var string */
    protected $event;

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

    public function calculate(Request $request)
    {
        $this->statistics->forEvent($this->event);

        $results = $this->statistics->fromTo($this->currentRange($request->get('range')))->associatedDateValue();

        return (new TrendResult)->trend($results);
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

    public function uriKey(): string
    {
        return $this->uriKey;
    }

    public function cacheFor()
    {
        return config('nova-mailgun.cache');
    }

    /**
     * Calculate the previous range and calculate any short-cuts.
     *
     * @param  string|int  $range
     * @return array
     */
    protected function previousRange($range)
    {
        if ($range == 'MTD') {
            return [
                now()->modify('first day of previous month')->setTime(0, 0),
                now()->subMonthsNoOverflow(1),
            ];
        }

        if ($range == 'QTD') {
            return $this->previousQuarterRange();
        }

        if ($range == 'YTD') {
            return [
                now()->subYears(1)->firstOfYear(),
                now()->subYearsNoOverflow(1),
            ];
        }

        return [
            now()->subDays($range * 2),
            now()->subDays($range),
        ];
    }

    /**
     * Calculate the previous quarter range.
     *
     * @return array
     */
    protected function previousQuarterRange()
    {
        return [
            Carbon::firstDayOfPreviousQuarter(),
            now()->subMonthsNoOverflow(3),
        ];
    }

    /**
     * Calculate the current range and calculate any short-cuts.
     *
     * @param  string|int  $range
     * @return array
     */
    protected function currentRange($range)
    {
        if ($range == 'MTD') {
            return [
                now()->firstOfMonth(),
                now(),
            ];
        }

        if ($range == 'QTD') {
            return $this->currentQuarterRange();
        }

        if ($range == 'YTD') {
            return [
                now()->firstOfYear(),
                now(),
            ];
        }

        return [
            now()->subDays($range),
            now(),
        ];
    }

    /**
     * Calculate the previous quarter range.
     *
     * @return array
     */
    protected function currentQuarterRange()
    {
        return [
            Carbon::firstDayOfQuarter(),
            now(),
        ];
    }
}
