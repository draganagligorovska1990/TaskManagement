<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="min-h-200  flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div class="p-10">
                <form @submit.prevent="filter">
                    <VueDatePicker id="dueDateFrom" placeholder="Date from" class="mb-1" v-model="form.date_from"></VueDatePicker>
                    <VueDatePicker id="dueDateTo" placeholder="Date to" class="mb-1" v-model="form.date_to"></VueDatePicker>
                    <select placeholder="Status" v-model="form.status" class="mb-1 block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="all">All statuses</option>
                        <option>To do</option>
                        <option>In progress</option>
                        <option>Completed</option>
                    </select>
                    <button class="inline-flex items-center text-blue-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="submit">
                        Filter
                    </button>
                </form>
            </div>

            <div>
                <a :href="route('task.create')">
                    <button class="inline-flex items-center text-green-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 mx-5" type="button">
                        Create task
                    </button>
                </a>
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
<!--                    <th scope="col" class="px-6 py-3">-->
<!--                        User-->
<!--                    </th>-->
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Due date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(task, index) in tasks" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
<!--                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">-->
<!--                        <div class="ps-3">-->
<!--                            <div class="text-base font-semibold">Neil Sims</div>-->
<!--                            <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>-->
<!--                        </div>-->
<!--                    </th>-->
                    <td class="px-6 py-4">
                        {{ task.title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.description }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.due_date }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            {{ task.status }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" v-on:click="showTaskDetails(task.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Details</a><br>
                        <a href="#" v-on:click="updateTask(task.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a><br>
                        <a href="#" v-on:click="deleteTask(task.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css';
</script>

<script>
const form = useForm();
export default {
    components: {VueDatePicker},
    props: {
        tasks: Array,
    },
    data() {
        return {
            form: {
                date_from: null,
                date_to: null,
                status: 'all'
            }
        }
    },
    created() {
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('status')) {
            this.form.status = urlParams.get('status');
        }
        if (urlParams.has('date_from')) {
            this.form.date_from = urlParams.get('date_from');
        }
        if (urlParams.has('date_to')) {
            this.form.date_to = urlParams.get('date_to');
        }
    },
    methods: {
        deleteTask(id) {
            if (confirm("Are you sure you want to Delete")) {
                form.delete(route('task.destroy', id));
            }
        },
        updateTask(id) {
            window.location.href = '/task/'+id+'/edit';
        },
        showTaskDetails (id) {
            window.location.href = '/task/'+id;
        },
        filter() {
            if (!this.form.date_to && !this.form.date_to && !this.form.status) {
                alert ("Please select min one filter!");
            } else {
                let dateFrom = null;
                let dateTo = null;
                let url = '/task?status=' + this.form.status;
                if (this.form.date_from !== undefined && this.form.date_from !== null) {
                    dateFrom = this.formatDate(new Date(this.form.date_from));
                    url = url + "&date_from="+dateFrom;
                }
                if (this.form.date_to !== undefined && this.form.date_to !== null) {
                    dateTo = this.formatDate(new Date(this.form.date_to));
                    url = url + "&date_to="+dateTo;
                }

                window.location.href = url;
            }
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
