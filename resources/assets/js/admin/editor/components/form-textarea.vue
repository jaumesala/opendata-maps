<template>

    <div :class="formClasses">
        <label for="{{ id }}">{{ label }}</label>
        <textarea   rows="5"
                    class="form-control"
                    id="{{ id }}"
                    name="{{ name }}"
                    placeholder="{{ placeholder }}"
                    v-model="model"
                    :disabled="isDisabled"
                    >

        </textarea>
        <p class="help-block" v-if="hasError">
            {{ errorMessage }}
        </p>
    </div>

</template>

<script>
    export default {
        props: [
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