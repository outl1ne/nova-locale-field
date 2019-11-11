<template>
  <div>
    <default-field :field="field" :errors="errors" v-if="!localePreviouslySet">
      <template slot="field">
        <select name="locale" class="w-full form-control form-input form-input-bordered" :class="errorClasses" v-model="locale" :disabled="localePreviouslySet">
          <option value="">Choose a locale</option>
          <option :value="locale.value" v-for="locale in field.locales" :key="locale.value">{{ locale.label }}</option>
        </select>
      </template>
    </default-field>

    <default-field :field="{ name: 'Locale parent' }" :errors="errors" v-if="parentResourceName">
      <template slot="field">
        <input type="text" :value="parentResourceName" readonly class="w-full form-control form-input form-input-bordered" />
      </template>
    </default-field>

    <locale-button v-if="localePreviouslySet" :field="field" :locale="locale" style="position: absolute; top: -8px; right: 0;" />
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { getParameterByName } from '../../js/util';
import LocaleButton from './LocaleButton';

export default {
  components: { LocaleButton },
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      localeParentId: void 0,
      locale: void 0,
      localePreviouslySet: void 0,
    };
  },

  computed: {
    parentResourceName() {
      return this.field.resources[this.localeParentId] || null;
    },
  },

  methods: {
    setInitialValue() {
      const value = this.field.value;
      this.localeParentId = (value && value.localeParentId) || getParameterByName('localeParentId');
      this.locale = (value && value.locale) || getParameterByName('locale') || '';
      this.localePreviouslySet = !!this.locale;
    },

    fill(formData) {
      if (this.localeParentId) formData.append(this.field.localeParentIdAttribute, this.localeParentId);
      if (this.locale) formData.append(this.field.localeAttribute, this.locale);
    },
  },
};
</script>
