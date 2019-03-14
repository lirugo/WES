require('./bootstrap');

window.Vue = require('vue');
// Slug
window.Slug = require('slug');
Slug.defaults.mode = "rfc3986";

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
Vue.component('chat-component', require('./components/Chat/ChatComponent'));
Vue.component('message-component', require('./components/Chat/MessageComponent'));

/*
|--------------------------------------------------------------------------
| Custom scripts
|--------------------------------------------------------------------------
*/
// Preloader
require ('./custom/preloader.js');
// Materialize Options
require ('./custom/materializeOptions.js');