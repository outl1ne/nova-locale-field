<template>
  <locale-options-list :field="field" :resource-name="resourceName" class="my-2" />
</template>

<script>
import LocaleOptionsList from './LocaleOptionsList';

export default {
  components: { LocaleOptionsList },
  props: ['resourceName', 'field'],
};
</script>
