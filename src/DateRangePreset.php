<?php

namespace Flux;

use Illuminate\Support\Carbon;

enum DateRangePreset: string
{
    case Today = 'today';
    case Yesterday = 'yesterday';
    case ThisWeek = 'thisWeek';
    case LastWeek = 'lastWeek';
    case Last7Days = 'last7Days';
    case ThisMonth = 'thisMonth';
    case LastMonth = 'lastMonth';
    case ThisQuarter = 'thisQuarter';
    case LastQuarter = 'lastQuarter';
    case ThisYear = 'thisYear';
    case LastYear = 'lastYear';
    case Last14Days = 'last14Days';
    case Last30Days = 'last30Days';
    case Last3Months = 'last3Months';
    case Last6Months = 'last6Months';
    case YearToDate = 'yearToDate';
    case AllTime = 'allTime';
    case Custom = 'custom';

    public function dates(Carbon $start = null)
    {
        return match ($this) {
            static::Today => [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Yesterday => [ Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay() ],
            static::ThisWeek => [ Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek() ],
            static::LastWeek => [ Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek() ],
            static::Last7Days => [ Carbon::now()->subDays(7)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::ThisMonth => [ Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth() ],
            static::LastMonth => [ Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth() ],
            static::ThisQuarter => [ Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter() ],
            static::LastQuarter => [ Carbon::now()->subQuarter()->startOfQuarter(), Carbon::now()->subQuarter()->endOfQuarter() ],
            static::ThisYear => [ Carbon::now()->startOfYear(), Carbon::now()->endOfYear() ],
            static::LastYear => [ Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear() ],
            static::Last14Days => [ Carbon::now()->subDays(14)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Last30Days => [ Carbon::now()->subDays(30)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Last3Months => [ Carbon::now()->subMonths(3)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Last6Months => [ Carbon::now()->subMonths(6)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::YearToDate => [ Carbon::now()->startOfYear(), Carbon::now()->endOfDay() ],
            static::AllTime => [ $start, Carbon::now()->endOfDay() ],
        };
    }

    public function label()
    {
        return match ($this) {
            static::Today => __('Today'),
            static::Yesterday => __('Yesterday'),
            static::ThisWeek => __('This Week'),
            static::LastWeek => __('Last Week'),
            static::Last7Days => __('Last 7 Days'),
            static::ThisMonth => __('This Month'),
            static::LastMonth => __('Last Month'),
            static::ThisQuarter => __('This Quarter'),
            static::LastQuarter => __('Last Quarter'),
            static::ThisYear => __('This Year'),
            static::LastYear => __('Last Year'),
            static::Last14Days => __('Last 14 Days'),
            static::Last30Days => __('Last 30 Days'),
            static::Last3Months => __('Last 3 Months'),
            static::Last6Months => __('Last 6 Months'),
            static::YearToDate => __('Year to Date'),
            static::AllTime => __('All Time'),
            static::Custom => __('Custom'),
        };
    }
}
