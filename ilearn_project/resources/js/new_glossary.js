// import 'bootstrap';
import {createApp} from 'vue';

import app from '../components/new_glossary.vue';
const apps = createApp(app)
apps.config.globalProperties.partner_upload = false
apps.config.productionTip = false
apps.mount('#new_glossary_vue');