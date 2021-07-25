require('./bootstrap');
import App from './components/App';
import TailablePagination from 'tailable-pagination';

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);
Vue.use(TailablePagination);

Vue.component('content-view', require('./components/ContentView.vue').default);
Vue.component('latest-deals', require('./components/widgets/LatestDeals.vue').default);

const app = new Vue({
    el: '#app',
    render(h) { return h(App) },
    router: new VueRouter(routes)
});