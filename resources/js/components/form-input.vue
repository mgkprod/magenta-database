<template>
    <label class="block">
        <span v-if="label" class="block mb-2 text-sm font-bold text-gray-100" v-text="label"></span>

        <input class="w-full px-4 py-2 mx-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-darker text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
            :class="{ 'bg-red-900 mb-1 border-red-500': errors.length }"
            v-bind="$attrs"
            v-on="{ ...$listeners, input: event => $emit('input', event.target.value) }">

        <p v-if="errors.length" class="pl-1 text-xs font-semibold text-red-500" v-text="errors[0]"></p>
    </label>
</template>

<script>
    export default {
        inheritAttrs: false,

        props: {
            id: String,
            label: String,
            errors: {
                type: Array,
                default: () => ([]),
            },
        },
    }
</script>
