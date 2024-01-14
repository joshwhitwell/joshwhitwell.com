<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <Link :href="route('logout')" as="button" method="post"> Log Out </Link>
</template>
