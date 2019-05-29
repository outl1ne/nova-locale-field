Nova.booting((Vue, router, store) => {
    Vue.component('index-nova-locale-field', require('./components/IndexField'))
    Vue.component('detail-nova-locale-field', require('./components/DetailField'))
    Vue.component('form-nova-locale-field', require('./components/FormField'))
})
