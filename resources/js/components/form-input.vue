<template>
  <label class="block">
    <span
      v-if="label"
      class="block mb-2 text-sm font-semibold text-gray-dark dark:text-gray-default"
      v-text="label"
    ></span>

    <input
      class="w-full px-3 py-2 text-sm transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
      :class="{ 'bg-red-900 mb-1 border-red-500': errors.length }"
      v-bind="$attrs"
      v-on="{ ...$listeners, input: (event) => $emit('input', event.target.value) }"
    />

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
      default: () => [],
    },
  },
};
</script>
