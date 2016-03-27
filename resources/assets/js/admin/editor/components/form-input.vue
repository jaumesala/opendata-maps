<template>

    <input v-if="type == 'hidden'"
                type="hidden"
                id="{{ id }}"
                name="{{ name }}"
                v-model="model"
                >

    <div :class="formClasses" v-if="type != 'hidden'">
        <label for="{{ id }}">{{ label }}</label>
        <input  class="form-control"
                type="{{ type }}"
                id="{{ id }}"
                name="{{ name }}"
                placeholder="{{ placeholder }}"
                v-model="model"
                :disabled="isDisabled"
                >
        <p class="help-block" v-if="hasError">
            {{ errorMessage }}
        </p>
    </div>

</template>



<script>
    export default {
        props: [
            'type',
            'name',
            'id',
            'placeholder',
            'label',
            'model',
            'hasError',
            'isDisabled'
        ],

        data: function () {
            return {
                errorMessage: "There's an error"
            }
        },

        computed: {
            formClasses: function(){
                return {
                    'form-group': true,
                    'has-error': this.hasError
                }
            }
        }

    }
</script>