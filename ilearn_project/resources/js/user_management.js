import {createApp} from 'vue';

import app from '../components/user_management.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#user_management_vue');