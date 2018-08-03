require('./bootstrap');

window.Vue = require('vue');
// Slug
window.Slug = require('slug');
Slug.defaults.mode = "rfc3986";

Vue.component('widget-slug', require('./components/widget/Slug'));

/*
|--------------------------------------------------------------------------
| Avatar Editor
|--------------------------------------------------------------------------
*/
import myUpload from 'vue-image-crop-upload';
new Vue({
    el: '#app',
    data: {
        show: false,
        params: {
            name: 'avatar',
        },
        headers: {
            'X-CSRF-Token': document.head.querySelector("[name=csrf-token]").content
        },
        imgDataUrl: '/uploads/avatars/male.png',
        avatarName: ''
    },
    components: {
        'widget-avatar-cropper': myUpload
    },
    methods: {
        toggleShow() {
            this.show = !this.show;
        },
        /**
         * crop success
         *
         * [param] imgDataUrl
         * [param] field
         */
        cropSuccess(imgDataUrl, field){
            console.log('-------- crop success --------');
            this.imgDataUrl = imgDataUrl;
        },
        /**
         * upload success
         *
         * [param] jsonData  server api return data, already json encode
         * [param] field
         */
        cropUploadSuccess(jsonData, field){
            console.log('-------- upload success --------');
            this.avatarName = jsonData.avatar;
        },
        /**
         * upload fail
         *
         * [param] status    server api return error status, like 500
         * [param] field
         */
        cropUploadFail(status, field){
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        }
    }
});
/*
|--------------------------------------------------------------------------
| Custom scripts
|--------------------------------------------------------------------------
*/
// Preloader
require ('./custom/preloader.js');
// Materialize Options
require ('./custom/materializeOptions.js');
