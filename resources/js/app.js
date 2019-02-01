require('./bootstrap')

window.Vue = require('vue')

import router from './routes'

Vue.config.productionTip = false

const app = new Vue({
    el: '#app',
    router
});
