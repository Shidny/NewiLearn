import {createApp} from 'vue';

import app from '../components/master_list.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#master_list_vue');