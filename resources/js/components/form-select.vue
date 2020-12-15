<template>
    <label class="block">
        <span v-if="label" class="block mb-2 text-sm font-bold text-gray-100" v-text="label"></span>

        <select class="w-full px-4 py-2 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
                :class="{ 'bg-red-100 mb-1': errors.length }"
                v-bind="$attrs"
                v-on="{ ...$listeners, input: event => $emit('input', event.target.value) }">
                <option v-for="(option, value) in options" v-bind:key="value" :value="value">{{ option }}</option>
        </select>

        <p v-if="errors.length" class="pl-1 text-xs italic font-semibold text-red-500" v-text="errors[0]"></p>
    </label>
</template>

<script>
    export default {
        /**
         * Determine if the attributes are passed to the root component.
         *
         * @type {Boolean}
         */
        inheritAttrs: false,

        /**
         * Component properties.
         *
         * @type {Object}
         */
        props: {
            id: String,
            label: String,
            options: Object,
            errors: {
                type: Array,
                default: () => ([]),
            },
        },
    }
</script>
