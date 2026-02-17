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
    case Tomorrow = 'tomorrow';
    case NextWeek = 'nextWeek';
    case Next7Days = 'next7Days';
    case NextMonth = 'nextMonth';
    case NextQuarter = 'nextQuarter';
    case NextYear = 'nextYear';
    case Next14Days = 'next14Days';
    case Next30Days = 'next30Days';
    case Next3Months = 'next3Months';
    case Next6Months = 'next6Months';
    case AllTime = 'allTime';
    case Custom = 'custom';

    public function dates(?Carbon $start = null)
    {
        return match ($this) {
            static::Today => [ Carbon::now()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Yesterday => [ Carbon::now()->subDay()->startOfDay(), Carbon::now()->subDay()->endOfDay() ],
            static::ThisWeek => [ Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek() ],
            static::LastWeek => [ Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek() ],
            static::Last7Days => [ Carbon::now()->subDays(7)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::ThisMonth => [ Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth() ],
            // If it is currently the 31st of the month, and we do `subMonth()`, if the previous month has 30 days, it will return the 1st of
            // the current month, not the 30th of the previous month. So we need to use `startOfMonth()` first before doing `subMonth()`...
            static::LastMonth => [ Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->startOfMonth()->subMonth()->endOfMonth() ],
            static::ThisQuarter => [ Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter() ],
            static::LastQuarter => [ Carbon::now()->subQuarter()->startOfQuarter(), Carbon::now()->subQuarter()->endOfQuarter() ],
            static::ThisYear => [ Carbon::now()->startOfYear(), Carbon::now()->endOfYear() ],
            static::LastYear => [ Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear() ],
            static::Last14Days => [ Carbon::now()->subDays(14)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Last30Days => [ Carbon::now()->subDays(30)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Last3Months => [ Carbon::now()->subMonths(3)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::Last6Months => [ Carbon::now()->subMonths(6)->addDay()->startOfDay(), Carbon::now()->endOfDay() ],
            static::YearToDate => [ Carbon::now()->startOfYear(), Carbon::now()->endOfDay() ],
            static::Tomorrow => [ Carbon::now()->addDay()->startOfDay(), Carbon::now()->addDay()->endOfDay() ],
            static::NextWeek => [ Carbon::now()->addWeek()->startOfWeek(), Carbon::now()->addWeek()->endOfWeek() ],
            static::Next7Days => [ Carbon::now()->startOfDay(), Carbon::now()->addDays(6)->endOfDay() ],
            static::NextMonth => [ Carbon::now()->endOfMonth()->addDay()->startOfDay(), Carbon::now()->endOfMonth()->addDay()->endOfMonth()->endOfDay() ],
            static::NextQuarter => [ Carbon::now()->addQuarter()->startOfQuarter(), Carbon::now()->addQuarter()->endOfQuarter() ],
            static::NextYear => [ Carbon::now()->addYear()->startOfYear(), Carbon::now()->addYear()->endOfYear() ],
            static::Next14Days => [ Carbon::now()->startOfDay(), Carbon::now()->addDays(13)->endOfDay() ],
            static::Next30Days => [ Carbon::now()->startOfDay(), Carbon::now()->addDays(29)->endOfDay() ],
            static::Next3Months => [ Carbon::now()->startOfDay(), Carbon::now()->addMonths(3)->subDay()->endOfDay() ],
            static::Next6Months => [ Carbon::now()->startOfDay(), Carbon::now()->addMonths(6)->subDay()->endOfDay() ],
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
            static::Tomorrow => __('Tomorrow'),
            static::NextWeek => __('Next Week'),
            static::Next7Days => __('Next 7 Days'),
            static::NextMonth => __('Next Month'),
            static::NextQuarter => __('Next Quarter'),
            static::NextYear => __('Next Year'),
            static::Next14Days => __('Next 14 Days'),
            static::Next30Days => __('Next 30 Days'),
            static::Next3Months => __('Next 3 Months'),
            static::Next6Months => __('Next 6 Months'),
            static::AllTime => __('All Time'),
            static::Custom => __('Custom'),
        };
    }
}
