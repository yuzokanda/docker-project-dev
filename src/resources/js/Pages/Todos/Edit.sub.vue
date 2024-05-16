<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    todo: Object,
    errors: Object
});

const form = reactive({
    id: props.todo.id,
    task: props.todo.task,
    description: props.todo.description,
    due_date: props.todo.due_date,
    due_time: props.todo.due_time,
    completed: props.todo.completed
});

const updateTodo = id => {
    Inertia.put(route('todos.update', { todo: id }), form)
};

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



</script>

<template>
    <div>
    <Head title="タスク編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">タスク編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeTodo">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                <div class="flex flex-wrap -m-2">
                                    <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="task" class="leading-7 text-sm text-gray-600">タスク</label>
                                        <div id="task" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ todo.task }}
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="description" class="leading-7 text-sm text-gray-600">説明</label>
                                        <div id="description" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                            {{ todo.description }}
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-2 w-1/2">
                                    <div class="relative">
                                        <label for="due_date" class="leading-7 text-sm text-gray-600">期日</label>
                                        <div id="due_date" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ formatDate(todo.due_date) }}
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-2 w-1/2">
                                    <div class="relative">
                                        <label for="due_time" class="leading-7 text-sm text-gray-600">時分</label>
                                        <div id="due_time" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ formatTime(todo.due_time) }}
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-2 w-full">
                                    <div class="relative">
                                        <label for="completed" class="leading-7 text-sm text-gray-600">ステイタス</label>
                                        <div id="completed" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            <span v-if="todo.completed === 0">未完了</span>
                                            <span v-if="todo.completed === 1">完了</span>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-2 w-full">
                                        <Link as="button" :href="route('todos.update', { todo: todo.id })" class="flex mx-auto text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">編集</Link>
                                    </div>
                                    <div class="p-2 mt-20 w-full">
                                    <button class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</div>
</template>
