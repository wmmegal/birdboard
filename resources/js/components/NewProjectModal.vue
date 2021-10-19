<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        123123
    </modal>
</template>

<script>
import BirdboardForm from './BirdboardForm';
export default {
    data() {
        return {
            form: new BirdboardForm({
                title: '',
                description: '',
                tasks: [
                    { body: ''},
                ]
            })
        };
    },
    methods: {
        addTask() {
            this.form.tasks.push({ body: '' });
        },
        async submit() {
            if (! this.form.tasks[0].body) {
                delete this.form.originalData.tasks;
            }
            this.form.submit('/projects')
                .then(response => location = response.data.message);
        }
    }
}
</script>
