<template>
  <div>
    <label class="inline-flex items-center mb-6">
      <input type="checkbox" class="w-5 h-5 transition duration-200 ease-in-out rounded appearance-none bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default form-checkbox focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500" v-bind="$attrs" :checked="value" @change="$emit('input', $event.target.checked)" />

      <span v-if="label" class="block ml-2 text-sm font-semibold text-gray-dark dark:text-gray-default" v-text="label"></span>
    </label>

    <p v-if="errors.length" class="pl-1 text-xs text-red-500" v-text="errors[0]"></p>
  </div>
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
    value: Boolean,
    errors: {
      type: Array,
      default: () => [],
    },
  },
};
</script>
