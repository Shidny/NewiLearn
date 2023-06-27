// import 'bootstrap';
import {createApp} from 'vue';

import app from '../components/announcement.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#announcement_vue');