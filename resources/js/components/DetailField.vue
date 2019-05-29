<template>
  <panel-item :field="field">
    <template slot="value">
      <locale-options-list :field="field" :resource="resource" :resource-id="resourceId" :resource-name="resourceName" />
    </template>
  </panel-item>
</template>

<script>
import LocaleOptionsList from './LocaleOptionsList';

export default {
  components: { LocaleOptionsList },
  props: ['resource', 'resourceName', 'resourceId', 'field'],
};
</script>
