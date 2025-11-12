<template>
    <RouterView />
</template>

<script setup lang="ts">
// Ничего лишнего — Pinia и Router уже подключены в main.ts
</script>

<style>
/* Глобальные Tailwind классы и небольшие UI-хелперы */
html, body, #app {
    height: 100%;
    margin: 0;
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f8fafc;
}

/* Опционально — плавные переходы страниц */
.page-enter-active, .page-leave-active {
    transition: opacity 0.2s ease;
}
.page-enter-from, .page-leave-to {
    opacity: 0;
}
</style>
