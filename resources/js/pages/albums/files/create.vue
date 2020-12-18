<template>
    <div class="p-8">
        <form @submit.prevent="submit">
            <form-input class="mb-6"
                label="Name"
                v-model="form.name"
                :errors="$page.props.errors.name"
            />

            <form-file-input class="mb-6"
                label="File"
                type="file"
                v-model="form.file"
                accept="file/*"
                ref="file"
                :errors="$page.props.errors.file"
            />

            <button class="flex items-center px-4 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in-out bg-gray-900 rounded shadow-inner hover:text-gray-300 hover:bg-gray-800 active:bg-transparent focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-gray-500">
                Chunked upload
                <span class="ml-1">{{ upload.progress }} %</span>
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        layout: require('../../../layouts/app').default,

        props: ['album', 'handle'],

        data() {
            return {
                form: {
                    name: '',
                    file: undefined,
                },
                upload: {
                    reader: undefined,
                    file: undefined,
                    slice_size: 5000 * 1024,
                    progress: 0,
                }
            }
        },

        methods: {
            submit() {
                this.$page.props.errors = {}
                this.start_upload();
            },
            start_upload(){
                this.upload.reader = new FileReader();
                this.upload.file = this.$refs.file.$el.querySelector('input').files[0];

                if (this.upload.file) this.upload_chunk(0);
            },
            upload_chunk(start) {
                let next_slice = start + (this.upload.slice_size + 1);
                let blob = this.upload.file.slice(start, next_slice);

                this.upload.reader.onloadend = (e) => {
                    if (e.target.readyState !== FileReader.DONE) {
                        return;
                    }

                    axios.post(
                        route('files.store.chunk'),
                        { handle: this.handle, file_data: e.target.result }
                    ).then((response) => {
                        let size_done = start + this.upload.slice_size;
                        this.upload.progress = Math.floor((size_done / this.upload.file.size) * 100);

                        if (next_slice < this.upload.file.size) {
                            this.upload_chunk(next_slice);
                        } else {
                            this.complete();
                        }
                    });
                };

                this.upload.reader.readAsDataURL(blob);
            },
            complete(){
                this.$inertia.post(
                    this.route('albums.files.store', this.album),
                    { handle: this.handle, name: this.form.name, file_name: this.upload.file.name, file_size: this.upload.file.size, file_type: this.upload.file.type }
                )
            }
        }
    }
</script>
