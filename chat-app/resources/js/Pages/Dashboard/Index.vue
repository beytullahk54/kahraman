<template>
  <div>
    <Head title="Dashboard" />
    <Rooms></Rooms>
  </div>
</template>

<script setup>

import { Head } from '@inertiajs/vue3';
import Rooms from '@/Shared/Rooms.vue';
import Layout from '@/Shared/Layout.vue';

defineOptions({ layout: Layout })

</script>

<style scoped>
/* Your styles here */
</style>
