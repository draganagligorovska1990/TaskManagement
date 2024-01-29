<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <div>
                <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 mx-5" type="button">
                    <span class="sr-only">Action button</span>
                    Action
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete User</a>
                    </div>
                </div>
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
<script>
import { useForm } from '@inertiajs/inertia-vue3'

const form = useForm();
export default {
    props: {
        tasks: Array,
    },
    data() {

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
        }
    }
}
</script>
