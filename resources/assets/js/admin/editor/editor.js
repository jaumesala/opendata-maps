var Vue = require('vue');

import formInput from './components/form-input.vue';
import formSelect from './components/form-select.vue';
import formTextarea from './components/form-textarea.vue';

new Vue({
    el: '#editor',

    components: {
        'form-input': formInput,
        'form-select': formSelect,
        'form-textarea': formTextarea,

    },

    data: {
        map: map,
        statusOptions: [
            { name: 'Public', id: 'public' },
            { name: 'Private', id: 'private' },
            { name: 'Disabled', id: 'disabled' }
        ]
    },

    ready: function(){
        console.log('Editor ready')
    }
});



