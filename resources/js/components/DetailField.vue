<template>
  <panel-item :field="field">
    <template slot="value">
      <locale-options-list :field="field" :resource="resource" :resource-id="resourceId" :resource-name="resourceName" />

      <div ref="localeButton">
        <button type="button" class="btn btn-default btn-primary inline-flex items-center relative mr-3">
          {{ localeDisplayName }}
        </button>
      </div>
    </template>
  </panel-item>
</template>

<script>
import LocaleOptionsList from './LocaleOptionsList';

export default {
  components: { LocaleOptionsList },
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  computed: {
    localeDisplayName() {
      return this.field.locales.find(l => l.value === this.field.value.locale).label;
    },
  },
  mounted() {
    const deleteButtonEl = document.querySelector('.content').querySelector('[dusk="open-delete-modal-button"]');
    deleteButtonEl.parentElement.insertBefore(this.$refs.localeButton, deleteButtonEl);
  },
};
</script>
