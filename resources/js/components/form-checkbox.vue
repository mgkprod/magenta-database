<template>
  <div class="flex items-center" :class="$attrs.class">
    <Checkbox
      v-bind="{ ...$attrs, class: undefined }"
      :input-id="id"
      :class="{ 'mb-1 border-red-500 bg-red-900': errors }"
      :binary="true"
      :model-value="modelValue"
      @update:model-value="$emit('update:modelValue', $event)"
    />

    <label v-if="label" :for="id" class="ml-2 block text-sm font-semibold text-gray-dark dark:text-gray-default" v-text="label" />
  </div>

  <p v-if="errors" class="pl-1 text-xs font-semibold text-red-500" v-text="typeof errors === 'string' ? errors : errors[0]" />
</template>

<script>
import Checkbox from 'primevue/checkbox'

export default {

  components: {
    Checkbox,
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
