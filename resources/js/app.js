import './bootstrap';
import { createApp } from 'vue'
import { v4 as uuidv4 } from 'uuid';


import VueCookies from 'vue-cookies';
import Game from './components/Game.vue'
 
const app = createApp()
 
app.use(VueCookies);
app.use(uuidv4);
app.component('game', Game)
app.mount('#app')