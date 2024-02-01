import './bootstrap';
import { createApp } from 'vue'
import Game from './components/Game.vue'
 
const app = createApp()
 
app.component('game', Game)
app.mount('#app')