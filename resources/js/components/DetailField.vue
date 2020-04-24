<template>
  <panel-item :field="field">
    <template slot="value">
      <locale-options-list
        :field="field"
        :resource="resource"
        :resource-id="resourceId"
        :resource-name="resourceName"
      />
      <locale-button :field="field" ref="localeButton" custom-class="mr-3" />
    </template>
  </panel-item>
</template>

<script>
import LocaleOptionsList from './LocaleOptionsList';
import LocaleButton from './LocaleButton';

export default {
  components: { LocaleOptionsList, LocaleButton },
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  mounted() {
    const deleteButtonEl = document.querySelector('.content').querySelector('[dusk="open-delete-modal-button"]');
    if (deleteButtonEl) {
      deleteButtonEl.parentElement.insertBefore(this.$refs.localeButton.$el, deleteButtonEl);
    }
  },
};
</script>
