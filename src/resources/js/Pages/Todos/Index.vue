<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import { computed, ref, watch } from 'vue';
import axios from 'axios';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    todos: Array
});

const todos = ref([...props.todos]);

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
    return todos.value.map(todo => ({
        ...todo,
        description: truncateDescription(todo.description)
    }));
});

// 現在の日時とdue_date/due_timeを比較する関数
const isDueWithin24Hours = (due_date, due_time) => {
    const dueDateTime = new Date(`${due_date}T${due_time}`);
    const now = new Date();
    const diffInHours = (dueDateTime - now) / 1000 / 60 / 60; // ミリ秒を時間に変換
    return diffInHours <= 24;
};

// 未完了と完了の切り替えボタン設置
const toggleCompletion = (todo) => {
    const newCompleted = !todo.completed;
    axios.put(`/api/todos/${todo.id}/toggle`, {
        completed: newCompleted
    })
    .then(response => {
            // 特定のtodoのcompletedプロパティを更新
        const index = todos.value.findIndex(t => t.id === todo.id);
        todos.value[index].completed = response.data.completed ? 1 : 0;
            console.log('更新が完了しました');
    })
    .catch(error => {
        console.error('更新に失敗しました', error);
    });
};

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
                                    <div class="flex justify-end my-3">
                                        <Link as="button" :href="route('todos.create')" class="flex ml-auto text-white bg-indigo-400 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-500 rounded">タスク追加</Link>
                                    </div>
                                    <div class="overflow-auto">
                                        <table class="table-auto w-full text-left whitespace-no-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">タスク</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100">説明</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100">期限</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100 text-center">ステイタス</th>
                                                    <th class="px-4 py-3 title-font tracking-widest font-medium text-gray-900 text-sm bg-gray-100 text-center rounded-tr rounded-br"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="todo in todosWithTruncatedDescription" :key="todo.id">
                                                    <td class="px-4 py-3" :class="{ 'line-through opacity-50': todo.completed === 1, 'text-red-500': isDueWithin24Hours(todo.due_date, todo.due_time) }">{{ todo.task }}</td>
                                                    <td class="px-4 py-3" :class="{ 'line-through opacity-50': todo.completed === 1, 'text-red-500': isDueWithin24Hours(todo.due_date, todo.due_time) }">{{ todo.description }}</td>
                                                    <td class="px-4 py-3" :class="{ 'line-through opacity-50': todo.completed === 1, 'text-red-500': isDueWithin24Hours(todo.due_date, todo.due_time) }">{{ formatDate(todo.due_date) }} &nbsp; {{ formatTime(todo.due_time) }}</td>
                                                    <td class="px-4 py-3 text-center">
                                                        <PrimaryButton @click="toggleCompletion(todo)" :class="{ 'bg-gray-400 text-white border-0 py-1 px-2 focus:outline-none hover:bg-gray-500 rounded': todo.completed === 0, 'bg-gray-300 text-white border-0 py-1 px-2 focus:outline-none hover:bg-gray-400 rounded opacity-50': todo.completed === 1 }">
                                                            <span v-if="todo.completed === 0">未完了</span>
                                                            <span v-if="todo.completed === 1">完了</span>
                                                        </PrimaryButton>
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
