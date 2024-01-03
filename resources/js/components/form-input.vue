<template>
    <label class="block" :class="$attrs.class">
    <span v-if="label" class="block mb-2 text-sm font-semibold text-gray-dark dark:text-gray-default" v-text="label"></span>

    <input
      class="w-full px-3 py-2 text-sm transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"
      :class="{ 'bg-red-900 mb-1 border-red-500': errors }"
      v-bind="{...$attrs, class: null, placeholder: null}"
      :value="modelValue"
      :type="type"
      @input="$emit('update:modelValue', $event.target.value)"
    />

    <p v-if="errors" class="pl-1 text-xs font-semibold text-red-500" v-text="errors"></p>
  </label>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    label: {
      type: String,
      default: undefined,
    },

    type: {
      type: String,
      default: 'text',
    },

    errors: {
      type: String,
      default: undefined,
    },

    modelValue: {
      type: String,
      default: undefined,
    },

    required: {
      type: Boolean,
      default: false,
    },

    helpText: {
      type: String,
      default: undefined,
    },

    placeholder: {
      type: String,
      default: undefined,
    },
  },

  emits: ['update:modelValue'],

  data() {
    return {
      id: undefined,
    }
  },

  created() {
    this.id = this.$attrs.id || this.$attrs.name
  },
}
</script>
