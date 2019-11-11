Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-locale-field', require('./components/IndexField').default);
  Vue.component('detail-nova-locale-field', require('./components/DetailField').default);
  Vue.component('form-nova-locale-field', require('./components/FormField').default);
});
