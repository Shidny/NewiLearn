// import './bootstrap';
import {createApp} from 'vue';

import app from '../components/home.vue';
const apps = createApp(app)
apps.config.productionTip = false
apps.mount('#home_vue');