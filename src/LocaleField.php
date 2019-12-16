<?php

namespace OptimistDigital\NovaLocaleField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class LocaleField extends Field
{
    /** @var String $component The Vue component for the field. */
    public $component = 'nova-locale-field';

    /** @var Array $locales Array of locales. */
    protected $locales;

    /** @var String|int $localeParentIdAttribute The attribute name for the locale parent ID column. */
    protected $localeParentIdAttribute;

    /** @var int $maxLocalesOnIndex The max number of locales shown on index config override value. */
    protected $maxLocalesOnIndex = null;

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
        $this->locales = self::getLocales();
        $this->locales = empty($this->locales) ? [] : $this->locales;
        $this->conditionsUpdated();
    }

    /**
     * Load the locales from the closure.
     *
     * @return array|null
     **/
    public static function getLocales()
    {
        $locales = config('nova-locale-field.locales', ['en' => 'English']);
        if (is_callable($locales)) return $locales();
        if (is_array($locales)) return $locales;
        return ['en' => 'English'];
    }

    /**
     * Forces a state update, hides the field on Index if conditions are met.
     *
     * @return \OptimistDigital\NovaLocaleField\LocaleField
     **/
    protected function conditionsUpdated()
    {
        $max = $this->maxLocalesOnIndex ?: config('nova-locale-field.max_locales_shown_on_index', 4);
        if (sizeof($this->locales) > $max) $this->hideFromIndex();
        return $this;
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
            'localeParentId' => $resource->{$this->localeParentIdAttribute},
            'existingLocalisations' => [],
        ];

        // Is master
        $queryParentId = empty($localeParentId) ? $id : $localeParentId;
        $children = $model::where($this->localeParentIdAttribute, $queryParentId)->orWhere('id', $queryParentId)->where('id', '!=', $id)->get();

        foreach (array_keys($locales) as $locale) {
            $existing = $children->first(function ($c) use ($locale) {
                return $c->locale === $locale;
            });
            $value['existingLocalisations'][$locale] = $existing !== null ? $existing->id : null;
        }

        $this->value = $value;

        // Add other resources
        $resources = $model::whereNull($this->localeParentIdAttribute)->get()
            ->map(function ($model) {
                $resource = Nova::resourceForModel(get_class($model));
                if (empty($resource)) return null;

                $instance = new $resource($model);
                return [
                    'id' => $model->id,
                    'label' => $instance->title(),
                ];
            })
            ->pluck('label', 'id');

        $this->withMeta([
            'asHtml' => true,
            'locales' => array_map(function ($localeKey) use ($locales) {
                return [
                    'label' => $locales[$localeKey],
                    'value' => $localeKey,
                ];
            }, array_keys($locales)),
            'resources' => $resources,
            'localeParentIdAttribute' => $this->localeParentIdAttribute,
            'localeAttribute' => $this->attribute,
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
        $this->fillInto($request, $model, $this->localeParentIdAttribute, $this->localeParentIdAttribute);
        return $this->fillInto($request, $model, $this->attribute, $this->attribute);
    }

    /**
     * Sets the locales of a specific field.
     *
     * @param array $locales Array of locales.
     * @return \OptimistDigital\NovaLocaleField\LocaleField
     **/
    public function locales(array $locales = null)
    {
        $this->locales = $locales;
        return $this->conditionsUpdated();
    }

    /**
     * Sets the max locales shown on index config override value.
     *
     * @param int $max Description
     * @return \OptimistDigital\NovaLocaleField\LocaleField
     **/
    public function maxLocalesOnIndex(int $max = null)
    {
        $this->maxLocalesOnIndex = $max;
        return $this->conditionsUpdated();
    }
}
