<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { computed } from 'vue';

const props = defineProps({
    todos: Array
})

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const month = date.getMonth() + 1; // getMonthは0から始まるため、1を足す
    const day = date.getDate();
    return `${month}/${day}`;
};

const formatTime = (timeString) => {
    const [hours, minutes] = timeString.split(':');
    return `${hours}:${minutes}`;
};

const truncateDescription = (description) => {
    return description.length > 15 ? description.substring(0, 15) + '...' : description;
};

const todosWithTruncatedDescription = computed(() => {
    return props.todos.map(todo => ({
        ...todo,
        description: truncateDescription(todo.description)
    }));
});

</script>

<template>
    <div>
    <Head title="タスク一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                タスク一覧
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-0 mx-auto">
                                <FlashMessage />
                                <div class="w-full mx-auto">
                                    <div class="flex justify-end my-4">
                                        <Link as="button" :href="route('todos.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">タスク追加</Link>
                                    </div>
                                    <div class="overflow-auto">
                                        <table class="table-auto w-full text-left whitespace-no-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">タスク</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100">説明</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100">期日</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100 text-center">ステイタス</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100 text-center rounded-tr rounded-br"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="todo in todosWithTruncatedDescription" :key="todo.id">
                                                    <td class="px-4 py-3" :class="{ 'line-through opacity-50': todo.completed === 1 }">{{ todo.task }}</td>
                                                    <td class="px-4 py-3" :class="{ 'line-through opacity-50': todo.completed === 1 }">{{ todo.description }}</td>
                                                    <td class="px-4 py-3" :class="{ 'line-through opacity-50': todo.completed === 1 }">{{ formatDate(todo.due_date) }} &nbsp; {{ formatTime(todo.due_time) }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        <span v-if="todo.completed === 0" class="text-orange-600">未完了</span>
                                                        <span v-if="todo.completed === 1" class="text-green-300">完了</span>
                                                    </td>
                                                    <td class="px-4 py-6">
                                                        <Link class="text-blue-400" :href="route('todos.show', { todo: todo.id })">詳細</Link>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</div>
</template>
