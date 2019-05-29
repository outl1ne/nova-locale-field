<template>
  <locale-options-list :field="field" :resource-name="resourceName" style="margin: 10px 0;" />
</template>

<script>
import LocaleOptionsList from './LocaleOptionsList';

export default {
  components: { LocaleOptionsList },
  props: ['resourceName', 'field'],
};
</script>