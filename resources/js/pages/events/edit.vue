<template>
  <div class="p-4 md:p-8">
    <form @submit.prevent="submit">
      <form-input class="mb-6" label="Name" v-model="form.name" :errors="$page.props.errors.name" required />

      <form-input class="mb-6" label="Happened at" v-model="form.happened_at" :errors="$page.props.errors.happened_at" />

      <form-textarea class="mb-6" label="Details" v-model="form.details" :errors="$page.props.errors.details" rows="10" />

      <form-file-input class="mb-6" label="Image" type="file" v-model="form.image" accept="image/*" :errors="$page.props.errors.image" />

      <div class="flex justify-end">
        <button class="inline-flex items-center px-4 py-1 text-sm font-semibold transition duration-200 ease-in-out rounded bg-gray-lightest dark:bg-gray-darker text-gray-dark dark:text-gray-default hover:bg-gray-light dark:hover:bg-gray-dark active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500"><i class="mr-2 opacity-50 fas fa-edit"></i> Edit</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/app').default,

  props: {
    event: Object,
  },

  data() {
    return {
      form: {
        name: '',
        happened_at: '',
        details: '',
        image: undefined,
      },
    };
  },

  mounted() {
    this.form.name = this.event.name;
    this.form.happened_at = this.moment(this.event.happened_at).format('YYYY-MM-DD');
    this.form.details = this.event.details;
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      var data = new FormData();
      data.append('_method', 'put');
      data.append('name', this.form.name || '');
      data.append('happened_at', this.form.happened_at || '');
      data.append('details', this.form.details || '');
      data.append('image', this.form.image || '');

      this.$inertia.post(this.route('events.update', this.event), data);
    },
  },
};
</script>
