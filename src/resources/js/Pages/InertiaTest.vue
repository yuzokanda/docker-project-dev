<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const newTitle = ref('');
const newContent = ref('');
</script>


<template>
    <div>
        Inertiaテストです。<br>
        <a href="/">aタグ経由です</a><br>
        <Link href="/">Link経由です</Link>
        <Link :href="route('inertia.index')">名前付きルートです</Link><br>
        <Link :href="route('inertia.show', { id : 1 })">ルードパラメータのテストです</Link><br>

        <div class="mb-8">
            <input type="text" name="newTitle" v-model="newTitle">{{ newTitle }}<br>
            <input type="text" name="newContent" v-model="newContent">{{ newContent }}<br>
            <Link as="button" method="post" :href="route('inertia.store')"
            :data="{
                title: newTitle,
                content: newContent
            }"
            >DB保存テスト</Link>


        </div>
    </div>
</template>
