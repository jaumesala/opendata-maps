<template>
    <div :class="formClasses">
        <label for="{{ id }}">{{ label }}</label>
        <select name="{{ name }}" v-model="model" :disabled="isDisabled" :multiple="isMultiple" :class="select2Class" data-options='{{ select2Options }}'>
            <option v-for="option in options" v-bind:value="option.id">
                {{ option.name }}
            </option>
        </select>
    </div>
</template>


<script>
    export default {
        props: [
            'name',
            'id',
            'label',
            'model',
            'options',
            'hasError',
            'isDisabled',
            'isSelect2',
            'select2Options',
            'isMultiple'
        ],

        data: function () {
            return {
                errorMessage: "no error"
            }
        },

        computed: {
            formClasses: function(){
                return {
                    'form-group': true,
                    'has-error': this.hasError
                }
            },

            select2Class: function(){
                return {
                    'form-control': true,
                    'select2': this.isSelect2
                }
            }
        },

        ready: function(){

            var $select = $(this.$el).find('.select2');

            if($select.length){
                $select .css('width', '100%')
                        .select2($select.data('options'))
                        .on("select2:select", function(e) {
                            console.log("assaasa");
                            this.$set('model', $select.val());
                        }.bind(this));
            }

        }
    }
</script>