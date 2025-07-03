<script setup>
const props = defineProps({
  workoutExerciseLog: Object,
});
</script>

<template>
  <div class="exercise-help">
    <p v-if="workoutExerciseLog.notes" class="exercise-notes">
      {{ workoutExerciseLog.notes }}
    </p>

    <a
      v-if="workoutExerciseLog.videoUrl"
      :href="workoutExerciseLog.videoUrl"
      class="video-url"
      target="_blank"
    >
      <span class="material-symbols-outlined"> play_arrow </span>
      Watch
    </a>

    <ul
      v-if="
        workoutExerciseLog?.substitutionOne ||
        workoutExerciseLog?.substitutionTwo
      "
      class="substitutions"
    >
      Substitutions:
      <li v-if="workoutExerciseLog.substitutionOne">
        <a
          v-if="workoutExerciseLog.substitutionOne.videoUrl"
          :href="workoutExerciseLog.substitutionOne.videoUrl"
          class="substitution-url"
          target="_blank"
        >
          {{ workoutExerciseLog.substitutionOne.name }}
        </a>
        <span v-else>
          {{ workoutExerciseLog.substitutionOne.name }}
        </span>
      </li>
      <li v-if="workoutExerciseLog.substitutionTwo">
        <a
          v-if="workoutExerciseLog.substitutionTwo.videoUrl"
          :href="workoutExerciseLog.substitutionTwo.videoUrl"
          class="substitution-url"
          target="_blank"
        >
          {{ workoutExerciseLog.substitutionTwo.name }}
        </a>
        <span v-else>
          {{ workoutExerciseLog.substitutionTwo.name }}
        </span>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.exercise-help {
  margin-block-end: var(--size-base);
}

.exercise-notes {
  font-size: var(--size-sm);
  margin-block-end: var(--size-3xs);
}

.video-url {
  align-items: center;
  background-color: transparent;
  border: 1px solid var(--color-neutral-950);
  border-radius: var(--size-base);
  font-size: var(--size-sm);
  font-weight: 500;
  display: flex;
  margin-block-end: var(--size-3xs);
  padding: var(--size-8xs) var(--size-xs);
  text-decoration: none;
  width: fit-content;
}

.substitutions {
  font-size: var(--size-sm);
  font-weight: 500;
  list-style-position: inside;
}

.substitutions li {
  font-weight: 400;
}

.video_url .material-symbols-outlined {
  font-size: var(--size-base);
  margin-inline-end: var(--size-8xs);
}
</style>
