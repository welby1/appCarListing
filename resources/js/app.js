require('./bootstrap');
import App from './components/App';
import TailablePagination from 'tailable-pagination';
import { store } from './store';

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';

Vue.use(VueRouter);
Vue.use(TailablePagination);

Vue.component('content-view', require('./components/ContentView.vue').default);
Vue.component('latest-deals', require('./components/widgets/LatestDeals.vue').default);
Vue.component('my-message', require('./components/chat/MyMessage.vue').default);
Vue.component('message', require('./components/Chat/Message.vue').default);
Vue.component('conversation', require('./components/PrivateMessage/Conversation.vue').default);

const app = new Vue({
    el: '#app',
    store,
    render(h) { return h(App) },
    router: new VueRouter(routes)
});