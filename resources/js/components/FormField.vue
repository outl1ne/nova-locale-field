<template>
  <div>
    <default-field :field="field" :errors="errors">
      <template slot="field">
        <select name="locale" class="w-full form-control form-input form-input-bordered" v-model="locale" :disabled="localePreviouslySet">
          <option value="">Choose a locale</option>
          <option :value="locale.value" v-for="locale in field.locales" :key="locale.value">{{ locale.label }}</option>
        </select>
      </template>
    </default-field>

    <default-field :field="field" :errors="errors">
      <template slot="field">
        <input type="text" :value="displayValue" readonly class="w-full form-control form-input form-input-bordered" />
      </template>
    </default-field>
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { getParameterByName } from '../../js/util';

export default {
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
    displayValue() {
      return this.field.resources[this.localeParentId] || '-';
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
