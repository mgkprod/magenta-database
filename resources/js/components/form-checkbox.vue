<template>
    <div class="flex items-center" :class="$attrs.class">
      <Checkbox
        v-bind="{ ...$attrs, class: undefined }"
        :inputId="id"
        :class="{ 'bg-red-900 mb-1 border-red-500': errors }"
        :binary="true"
        :modelValue="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
      />

      <label v-if="label" v-text="label" :for="id" class="block ml-2 text-sm font-semibold text-gray-dark dark:text-gray-default"></label>
    </div>

    <p v-if="errors" class="pl-1 text-xs font-semibold text-red-500" v-text="typeof errors === 'string' ? errors : errors[0]"></p>
</template>

<script>
import Checkbox from 'primevue/checkbox';

export default {
  inheritAttrs: false,

  components: {
    Checkbox,
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
