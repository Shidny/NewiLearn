import {createApp} from 'vue';

import app from '../components/my_profile.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#my_profile_vue');