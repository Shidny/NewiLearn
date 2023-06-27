// import './bootstrap';
import '../sass/app.scss'

import {createApp} from 'vue';

import app from '../components/loginform.vue';
const apps = createApp(app)
apps.config.productionTip = false
apps.mount('#app');