require('./bootstrap');

window.Vue = require('vue');
// Slug
window.Slug = require('slug');
Slug.defaults.mode = "rfc3986";

// Slug Editor
Vue.component('widget-slug', require('./components/widget/Slug'));
// Avatar Editor
Vue.component('widget-avatar-cropper', require('vue-image-crop-upload'));

/*
|--------------------------------------------------------------------------
| Custom scripts
|--------------------------------------------------------------------------
*/
// Preloader
require ('./custom/preloader.js');
// Materialize Options
require ('./custom/materializeOptions.js');
