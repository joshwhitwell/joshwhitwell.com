<script setup>
import Layout from '../../../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ programs: Array });
</script>

<template>
  <Layout>
    <Link :href="route('lift.admin.programs.create')"> + New Program </Link>
    <table>
      <thead>
        <tr>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="program in programs" :key="program.id">
          <td>
            <Link :href="route('lift.admin.programs.edit', program.id)">
              {{ program.name }}
            </Link>
          </td>
        </tr>
      </tbody>
    </table>
  </Layout>
</template>
