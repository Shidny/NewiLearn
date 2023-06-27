// import 'bootstrap';
import {createApp} from 'vue';

import app from '../components/audit_trail.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#audit_trail_vue');