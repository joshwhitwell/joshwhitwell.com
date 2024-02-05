<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PaperPlane from "../../../Svg/PaperPlane.vue";
defineProps({
  notes: {
    type: Array,
    default: () => [],
  },
});
const note = useForm({
  body: "",
});
const saveNoteButton = ref(null);
const saveNote = () => {
  note.post(route("my.notes.store"), {
    onSuccess: () => {
      note.reset();
      saveNoteButton.value.blur();
    },
  });
};
</script>

<template>
  <form @submit.prevent="saveNote">
    <textarea id="note" name="note" v-model="note.body" />
    <button ref="saveNoteButton"><PaperPlane /></button>
  </form>
  <ul v-if="notes.length">
    <li v-for="note in notes" :key="note.id">
      <a :href="route('my.notes.edit', note.id)">
        <span>{{ note.created_at }}</span>
        {{ note.body }}
      </a>
    </li>
    <li v-if="notes.length === 3">
      <a :href="route('my.notes.index')">&hellip;</a>
    </li>
  </ul>
</template>

<style scoped>
form {
  display: flex;
  flex-direction: column;
}

textarea {
  height: calc(var(--vertical-spacing) * 10);
  resize: none;
}

button {
  align-items: center;
  background: none;
  border-top: none;
  border-left: 2px solid var(--neutral-300);
  border-right: 2px solid var(--neutral-300);
  border-bottom: 2px solid var(--neutral-300);
  box-sizing: border-box;
  cursor: pointer;
  color: var(--neutral-300);
  display: flex;
  justify-content: center;
}

svg {
  color: var(--neutral-400);
  height: 20px;
  width: 20px;
}

li {
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  position: relative;
  margin: 0.5rem 0 0;
}

a:after {
  content: "";
  display: block;
  height: 100%;
  width: 100%;
  background: linear-gradient(to right, transparent 0%, var(--neutral-50) 99%);
  position: absolute;
  top: 0;
  left: 0;
}

li a {
  color: var(--font-color);
}

a span {
  color: var(--neutral-400);
  margin-right: var(--vertical-spacing);
}

li:nth-child(4) {
  margin-top: 0;
}
</style>
