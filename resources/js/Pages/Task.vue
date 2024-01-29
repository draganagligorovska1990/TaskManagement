<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
</script>

<template>
    <Head title="Create Task" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 v-if="editing" class="font-semibold text-xl text-gray-800 leading-tight">Edit Task</h2>
            <h2 v-else class="font-semibold text-xl text-gray-800 leading-tight">Create Task</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form class="w-full max-w-lg h-900">
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-title">
                                        Title *
                                    </label>
                                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-title" type="text" placeholder="Title" v-model="form.title">
                                </div>
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <div class="relative">
                                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                                            Due date *
                                        </label>
                                        <VueDatePicker id="dueDate" v-model="form.due_date"></VueDatePicker>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                        Description
                                    </label>
                                    <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your task description here..." v-model="form.description"></textarea>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-2">
                                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                                        Status *
                                    </label>
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" v-model="form.status">
                                            <option>To do</option>
                                            <option>In progress</option>
                                            <option>Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="md:flex md:items-center">
                                <div>
                                    <button v-if="editing" @click="update" class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">
                                        Save
                                    </button>
                                    <button v-else @click="save" class="shadow bg-green-500 hover:bg-green-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button">
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
export default {
    props: ['task'],
    data() {
        return {
            form: {
                title: '',
                description: null,
                due_date: null,
                status: ''
            },
            editing: false
        }
    },
    mounted() {
        if(this.task) {
            this.form = this.task
            this.editing = true
        }
    },
    methods: {
        save() {
            let currentObj = this;
            axios.post('/task', {
                title: this.form.title,
                description: this.form.description,
                due_date: this.formatDate(this.form.due_date),
                status: this.form.status
            }).then(function(response) {
                currentObj.output = response.data;
                window.location.href = '/task';
            }).catch(function(error) {
                currentObj.output = error;
            });
        },
        update() {
            let currentObj = this;
            axios.put('/task/'+this.task.id, {
                title: this.form.title,
                description: this.form.description,
                due_date: this.formatDate(new Date(this.form.due_date)),
                status: this.form.status
            }).then(function(response) {
                currentObj.output = response.data;
                window.location.href = '/task';
            }).catch(function(error) {
                currentObj.output = error;
            });
        },
        formatDate(date) {
            let year = date.getFullYear();
            let month = date.getMonth() + 1;
            let day = date.getDate();
            let hours = date.getHours();
            let minutes = date.getMinutes();

            return year + "-" + (month > 9 ? '' : '0') + month + "-" + (day > 9 ? '' : '0') + day + " " + (hours > 9 ? '' : '0') + hours + ":" + (minutes > 9 ? '' : '0') + minutes + ":00";
        }
    }
}
</script>
