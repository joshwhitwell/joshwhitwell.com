<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({ layout: Layout });

defineProps({ programLogs: Object });
</script>

<template>
  <div>
    <Link
      v-for="programLog in programLogs.data"
      :key="programLog.id"
      :href="'/'"
      >{{ programLog.program.name }}</Link
    >
  </div>
</template>
