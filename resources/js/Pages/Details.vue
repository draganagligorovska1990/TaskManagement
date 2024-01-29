<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Create Task" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>Title: {{ task.title }}</div>
                        <div>Description: {{ task.description }}</div>
                        <div>Due date: {{ task.due_date }}</div>
                        <div>Status: {{ task.status }}</div>
                    </div>
                    <div v-for="comment in comments" class="p-6 bg-white border-b border-gray-200">
                        {{ comment.comment }}
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>

export default {
    props: {
        task: Object,
        comments: Object
    }
}
</script>
