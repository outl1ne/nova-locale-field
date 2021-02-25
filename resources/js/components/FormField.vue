<template>
  <div>
    <default-field :field="field" :errors="errors" v-if="!localePreviouslySet">
      <template slot="field">
        <select
          name="locale"
          class="w-full form-control form-input form-input-bordered"
          :class="errorClasses"
          v-model="locale"
          :disabled="localePreviouslySet"
        >
          <option value="">Choose a locale</option>
          <option :value="locale.value" v-for="locale in field.locales" :key="locale.value">{{ locale.label }}</option>
        </select>
      </template>
    </default-field>

    <default-field :field="{ name: 'Locale parent' }" :errors="errors" v-if="parentResourceName">
      <template slot="field">
        <input
          type="text"
          :value="parentResourceName"
          readonly
          class="w-full form-control form-input form-input-bordered"
        />
      </template>
    </default-field>

    <locale-button v-show="localePreviouslySet" :field="field" :locale="locale" ref="localeButton" />
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
      locale: void 0,
      localeParentId: void 0,
      localePreviouslySet: void 0,
    };
  },

  mounted() {
    const formHeading = document.querySelector('form > * > h1');
    if (formHeading && this.$refs.localeButton) {
      formHeading.style.display = 'flex';
      formHeading.style['align-items'] = 'center';
      this.$nextTick(() => formHeading.append(this.$refs.localeButton.$el));
    }
  },

  watch: {
    '$route.query': {
      handler(query) {
        const value = this.field.value;

        this.$router.go();

        const newLocale = (value && value.locale) || query.locale;
        if (newLocale) this.locale = newLocale;

        const newParent = (value && value.localeParentId) || query.localeParentId;
        if (newParent) this.localeParentId = newParent;
      },
    },
  },

  computed: {
    parentResourceName() {
      return (this.field.resources && this.field.resources[this.localeParentId]) || null;
    },
  },

  methods: {
    setInitialValue() {
      const value = this.field.value;
      const query = this.$router.currentRoute.query;

      this.locale = (value && value.locale) || query.locale;
      this.localeParentId = (value && value.localeParentId) || query.localeParentId;

      this.localePreviouslySet = !!this.locale;

      if (!this.locale) this.locale = this.field.locales[0].value;
    },

    fill(formData) {
      if (this.localeParentId) formData.append(this.field.localeParentIdAttribute, this.localeParentId);
      if (this.locale) formData.append(this.field.localeAttribute, this.locale);
    },
  },
};
</script>
