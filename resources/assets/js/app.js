require('./bootstrap');

window.Vue = require('vue');
// Slug
window.Slug = require('slug');
Slug.defaults.mode = "rfc3986";

// Slug Editor
Vue.component('widget-slug', require('./components/widget/Slug'));
// Countdown
Vue.component('widget-countdown', require('./components/widget/Countdown'));
// Avatar Editor
Vue.component('widget-avatar-cropper', require('vue-image-crop-upload'));

//Group Work
Vue.component('group-work-create', require('./components/team/group-work/Create'));
/*
|--------------------------------------------------------------------------
| Custom scripts
|--------------------------------------------------------------------------
*/
// Preloader
require ('./custom/preloader.js');
// Materialize Options
require ('./custom/materializeOptions.js');
