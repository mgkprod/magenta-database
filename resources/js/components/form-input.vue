<template>
  <label class="block" :class="$attrs.class" :for="id">
    <span v-if="label" class="mb-2 block text-sm font-semibold text-gray-dark dark:text-gray-default" v-text="label" />

    <InputText
      v-bind="{ ...$attrs, class: undefined }"
      :id="id"
      :class="{ 'mb-1 border-red-500 bg-red-900': errors }"
      :model-value="modelValue"
      @update:model-value="$emit('update:modelValue', $event)"
    />

    <p v-if="errors" class="pl-1 text-xs font-semibold text-red-500" v-text="typeof errors === 'string' ? errors : errors[0]" />
  </label>
</template>

<script>
import InputText from 'primevue/inputtext'

export default {

  components: {
    InputText,
  },

  inheritAttrs: false,

  props: {
    label: {
      type: String,
      default: undefined,
    },

    errors: {
      type: [String, Array],
      default: undefined,
    },

    modelValue: {
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
    this.id = this.$attrs.id || Math.random().toString()
  },
}
</script>
