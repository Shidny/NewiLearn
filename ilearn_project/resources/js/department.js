import {createApp} from 'vue';

import app from '../components/department.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#department_vue');