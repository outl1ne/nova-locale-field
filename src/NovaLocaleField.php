<?php

namespace OptimistDigital\NovaLocaleField;

use Laravel\Nova\Fields\Field;

class NovaLocaleField extends Field
{
    /** @var String $component The Vue component for the field. */
    public $component = 'nova-locale-field';

    /** @var Closure $getLocales Closure that returns the locales in an array. */
    protected static $getLocales;

    /** @var Array $locales Array of locales. */
    protected $locales;

    /** @var String|Number $localeParentIdAttribute The attribute name for the locale parent ID column. */
    protected $localeParentIdAttribute;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|null $attribute
     * @param mixed|null $resolveCallback
     * @return void
     **/
    public function __construct($name, $localeAttribute, $localeParentIdAttribute, $resolveCallback = null)
    {
        parent::__construct($name, $localeAttribute, $resolveCallback);

        $this->localeParentIdAttribute = $localeParentIdAttribute;

        // Retrieve locales
        $this->locales = is_callable(static::$getLocales) ? static::$getLocales() : null;
        $this->locales = empty($this->locales) ? [] : $this->locales;
    }

    /**
     * Set the Closure that fetches the locales.
     *
     * @param Closure $getLocales
     * @return void
     **/
    public function getLocales(Closure $getLocales)
    {
        $this::$getLocales = $getLocales;
    }

    /**
     * Resolve the field's value.
     *
     * @param mixed $resource
     * @param string|null $attribute
     * @return void
     */
    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);

        // Base variables
        $id = $resource->id;
        $locales = $this->locales;
        $model = get_class($resource);
        $localeParentId = $resource->{$this->localeParentIdAttribute};

        // Meta
        $value = [
            'id' => $id,
            'locale' => $resource->{$this->attribute},
            'locale_parent_id' => $resource->{$this->localeParentIdAttribute},
            'locales' => []
        ];

        // Is master
        $queryParentId = empty($localeParentId) ? $id : $localeParentId;
        $children = $model::where($this->localeParentIdAttribute, $queryParentId)->where('id', '!=', $id)->get();

        foreach (array_keys($locales) as $locale) {
            $value['locales'][$locale] = $children->first(function ($c) use ($locale) {
                return $c->locale === $locale;
            });
        }

        $this->value = $value;

        // Add other resources
        $resources = $model::whereNull($this->localeParentIdAttribute)->get()
            ->map(function ($resource) {
                return [
                    'id' => $resource->id,
                    'label' => $resource->title(),
                ];
            })
            ->pluck('label', 'id');

        $this->withMeta([
            'asHtml' => true,
            'locales' => $locales,
            'resources' => $resources,
        ]);

        $this->rules('required', 'in:' . implode(',', array_keys($this->locales)));
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  object  $model
     * @return mixed
     */
    public function fill(NovaRequest $request, $model)
    {
        // TODO
        return $this->fillInto($request, $model, $this->attribute);
    }
}
