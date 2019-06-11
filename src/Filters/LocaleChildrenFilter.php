<?php

namespace OptimistDigital\NovaLocaleField\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class LocaleChildrenFilter extends BooleanFilter
{
    public $name = 'Locale children';
    public $component = 'boolean-filter';
    protected $localeParentIdKey;

    public static function make($localeParentIdKey = 'locale_parent_id')
    {
        return new static($localeParentIdKey);
    }

    public function __construct($localeParentIdKey = 'locale_parent_id')
    {
        $this->localeParentIdKey = $localeParentIdKey;
    }

    public function apply(Request $request, $query, $value)
    {
        if (isset($value['show_localisation_children']) && $value['show_localisation_children']) return $query;
        return $query->whereNull($this->localeParentIdKey);
    }

    public function options(Request $request)
    {
        return [
            'Show localisations' => 'show_localisation_children'
        ];
    }

    public function default()
    {
        return [
            'show_localisation_children' => false
        ];
    }
}
