<template>
  <label class="block" :class="$attrs.class" :for="id">
    <span v-if="label" v-text="label" class="block mb-2 text-sm font-semibold text-gray-dark dark:text-gray-default" />

    <InputText
      v-bind="{ ...$attrs, class: undefined }"
      :id="id"
      :class="{ 'bg-red-900 mb-1 border-red-500': errors }"
      :modelValue="modelValue"
      @update:modelValue="$emit('update:modelValue', $event)"
    />

    <p v-if="errors" class="pl-1 text-xs font-semibold text-red-500" v-text="typeof errors === 'string' ? errors : errors[0]"></p>
  </label>
</template>

<script>
import InputText from 'primevue/inputtext';

export default {
  inheritAttrs: false,

  components: {
    InputText,
  },

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
