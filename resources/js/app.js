require('./bootstrap');
require('alpinejs');
import useValidate from '@vuelidate/core';
import { createApp } from 'vue';
import moment from 'moment';
import { createRouter, createWebHistory  } from 'vue-router'
import PrimeVue from 'primevue/config'
import Calendar from 'primevue/calendar';
import MultiSelect from 'primevue/multiselect';
import TabMenu from 'primevue/tabmenu';
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Toast from 'primevue/toast'
import ToastService from 'primevue/toastservice';
import Card from 'primevue/card';
import Timeline from 'primevue/timeline';
import Fieldset from 'primevue/fieldset';
import axios from 'axios'
import VueAxios from 'vue-axios'
import Dialog from 'primevue/dialog';
import DataTable from 'primevue/datatable';
import Tooltip from 'primevue/tooltip';
import Dropdown from 'primevue/dropdown';
import RadioButton from 'primevue/radiobutton';
import Textarea from 'primevue/textarea';
import Sidebar from 'primevue/sidebar';
import ProgressBar from 'primevue/progressbar';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Message from 'primevue/message';
import InputMask from 'primevue/inputmask';
import ProgressSpinner from 'primevue/progressspinner';
import 'primevue/resources/themes/saga-blue/theme.css'       //theme
import 'primevue/resources/primevue.min.css'                 //core css
import 'primeicons/primeicons.css'                            //icons
import {routes} from './routes'
import TicketMain from './components/TicketMain'
import UsersBlocked from './components/UsersBlocked'
import CarMatch from './components/CarMatch'
import Client from './components/Client'
import CampaingsMain from './components/CampaingsMain'
import CouponsMain from './components/CouponsMain'
import Error from './components/Error'
moment.locale('es');
const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp({});
app.config.globalProperties.$moment=moment;
app.use(router);
app.use(PrimeVue);
app.use(ToastService);
app.use(VueAxios, axios);
app.use(useValidate);
app.component('CampaingsMain', CampaingsMain);
app.component('CouponsMain', CouponsMain);
app.component('Calendar', Calendar);
app.component('Calendar', Calendar);
app.component('MultiSelect', MultiSelect);
app.component('InputText', InputText);
app.component('Button', Button);
app.component('InputMask', InputMask);
app.component('Toast', Toast);
app.component('Timeline', Timeline);
app.component('Card', Card);
app.component('Fieldset', Fieldset);
app.component('TicketMain', TicketMain);
app.component('UsersBlocked', UsersBlocked);
app.component('CarMatch', CarMatch);
app.component('Error', Error);
app.component('Client', Client);
app.component('Dialog', Dialog);
app.component('TabMenu', TabMenu);
app.component('DataTable', DataTable);
app.directive('tooltip', Tooltip);
app.component('Sidebar', Sidebar);
app.component('ProgressBar', ProgressBar);
app.component('Dropdown', Dropdown );
app.component('RadioButton', RadioButton );
app.component('Textarea', Textarea );
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup );
app.component('Message', Message );
app.component('ProgressSpinner', ProgressSpinner );
app.mount('#app');
