<?php

namespace OptimistDigital\NovaLocaleField\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use OptimistDigital\NovaLocaleField\LocaleField;

class LocaleFilter extends Filter
{
    public $name = 'Locale Filter';
    public $component = 'select-filter';
    protected $localeFieldKey;
    protected $locales;

    public static function make($localeFieldKey = 'locale')
    {
        return new static($localeFieldKey);
    }

    public function __construct($localeFieldKey = 'locale')
    {
        $this->localeFieldKey = $localeFieldKey;
        $this->locales = LocaleField::loadLocales();
    }

    public function apply(Request $request, $query, $value)
    {
        return $query->where($this->localeFieldKey, $value);
    }

    public function options(Request $request)
    {
        return array_flip($this->locales);
    }

    /**
     * Set the locales for the filter.
     *
     * @param array $locales
     * @return OptimistDigital\NovaLocaleField\Filters\LocaleFilter
     **/
    public function locales($locales = [])
    {
        $this->locales = $locales;
        return $this;
    }
}
