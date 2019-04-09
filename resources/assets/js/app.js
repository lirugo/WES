require('./bootstrap');

window.Vue = require('vue');
// Slug
window.Slug = require('slug');
Slug.defaults.mode = "rfc3986";

// import Vuex from 'vuex'
// Vue.use(Vuex)

import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)

Vue.use(require('vue-chat-scroll'))

//Vue datepicker && timepicker
Vue.component('datepicker', require('vue-datepicker'));
// Slug Editor
Vue.component('widget-slug', require('./components/widget/Slug'));
// Countdown
Vue.component('widget-countdown', require('./components/widget/Countdown'));
// Avatar Editor
Vue.component('widget-avatar-cropper', require('vue-image-crop-upload'));

// Group Work
    Vue.component('group-work-create', require('./components/team/group-work/Create'));
    // List
    Vue.component('group-work-list', require('./components/team/group-work/List'));
    // Row
    Vue.component('group-work-row', require('./components/team/group-work/Row'));

// Chat
Vue.component('chat-component', require('./components/chat/ChatComponent'));
Vue.component('message-component', require('./components/chat/MessageComponent'));
//Conversations
Vue.component('conversations-dashboard', require('./components/conversations/ConversationsDashboard'));
Vue.component('conversations', require('./components/conversations/Conversations'));
Vue.component('conversation-reply-form', require('./components/conversations/ConversationReplyForm'));
Vue.component('conversation-form', require('./components/conversations/ConversationForm'));
Vue.component('conversation', require('./components/conversations/Conversation'));

/*
|--------------------------------------------------------------------------
| Custom scripts
|--------------------------------------------------------------------------
*/
// Preloader
require ('./custom/preloader.js');
// Materialize Options
require ('./custom/materializeOptions.js');

// import store from './store/index'

// const app = new Vue({
//     el: '#app',
//     store
// })
