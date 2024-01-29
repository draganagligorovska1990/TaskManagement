<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Create Task" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add comment</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="w-full max-w-lg h-900">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                        Comment
                                    </label>
                                    <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your comment here..." v-model="form.comment"></textarea>
                                    <span class="text-red-600" v-if="errors?.comment">{{ errors.comment[0] }}</span>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="md:flex md:items-center">
                                <div>
                                    <button class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
const errors = ref({})

export default {
    props: ['task'],
    data() {
        return {
            form: {
                comment: ''
            }
        }
    },
    methods: {
        submit() {
            let currentObj = this;
            let task = this.task.id;
            axios.post('/comment', {
                comment: this.form.comment,
                task_id: task
            }).then(function(response) {
                currentObj.output = response.data;
                window.location.href = "/task/" + task;
            }).catch(function(error) {
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors
                }
                currentObj.output = error;
            });
        }
    }
}
</script>
