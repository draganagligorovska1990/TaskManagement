<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import TableLayout from "@/Components/Table.vue";
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <TableLayout :tasks="tasks" :isAdmin="isAdmin">

        </TableLayout>
    </BreezeAuthenticatedLayout>
</template>
<script>
export default {
    props: {
        tasks: Array,
        isAdmin: Boolean
    }
}
</script>
