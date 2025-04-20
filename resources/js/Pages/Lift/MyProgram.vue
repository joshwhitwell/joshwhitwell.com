<script setup>
import MyProgramPhase from '../../Components/Lift/MyProgramPhase.vue';
import MyProgramWeek from '../../Components/Lift/MyProgramWeek.vue';
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ programLog: Object });
</script>

<template>
  <Layout>
    <template #navigation>
      <Link :href="route('lift.my.programs.index')" class="back-link">
        <span class="material-symbols-outlined"> arrow_back_ios </span>
        Back to programs
      </Link>
    </template>

    <h1 class="page-title">{{ programLog.name }}</h1>

    <div v-if="programLog?.phaseLogs?.length">
      <MyProgramPhase
        v-for="phaseLog in programLog.phaseLogs"
        :key="`phase-log--${phaseLog.id}`"
        :program-log="programLog"
        :phase-log="phaseLog"
      />
    </div>

    <div v-else-if="programLog?.weekLogs?.length">
      <MyProgramWeek
        v-for="weekLog in programLog.weekLogs"
        :key="`week-log--${weekLog.id}`"
        :program-log="programLog"
        :week-log="weekLog"
      />
    </div>
  </Layout>
</template>

<style scoped></style>
