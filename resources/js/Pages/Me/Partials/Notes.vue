<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import PaperPlane from "../../../Svg/PaperPlane.vue";

const note = useForm({
  body: "",
});
const saveNoteButton = ref(null);
const saveNote = () => {
  note.post(route("notes.store"), {
    onSuccess: () => {
      note.reset();
      saveNoteButton.value.blur();
    },
  });
};

const now = ref(new Date());
setInterval(() => {
  now.value = new Date();
}, 60000);
</script>

<template>
  <form class="notes" @submit.prevent="saveNote">
    <h2>
      <span class="date--long">
        {{
          now.toLocaleString("en-US", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
          })
        }}
      </span>
      <span class="date--short">
        {{
          now.toLocaleString("en-US", {
            month: "2-digit",
            day: "2-digit",
            year: "numeric",
          })
        }}
      </span>
      {{
        now.toLocaleTimeString("en-US", {
          hour: "numeric",
          minute: "numeric",
        })
      }}
    </h2>
    <textarea id="note" name="note" v-model="note.body" />
    <button ref="saveNoteButton"><PaperPlane /></button>
  </form>
</template>

<style scoped>
.notes {
  position: relative;
  height: 228px;
  width: 100%;
}

h2 {
  color: var(--neutral-400);
  font-weight: 400;
  font-style: italic;
  margin: 0;
  padding: 10px 0 0 10px;
  position: absolute;
}

.date--long {
  display: none;
}

.date--short {
  display: inline;
}

@media (min-width: 700px) {
  .date--long {
    display: inline;
  }

  .date--short {
    display: none;
  }
}

textarea {
  background-color: transparent;
  border: 1px solid var(--neutral-300);
  border-radius: 0;
  box-sizing: border-box;
  font-family: inherit;
  font-size: inherit;
  height: 100%;
  margin: 0;
  outline: none;
  padding: 43px 0 0 10px;
  position: absolute;
  resize: none;
  width: 100%;
}

textarea:focus {
  border-color: var(--neutral-500);
}

button {
  align-items: center;
  background: none;
  border: none;
  bottom: 0;
  box-sizing: border-box;
  cursor: pointer;
  display: flex;
  justify-content: center;
  padding: 10px;
  position: absolute;
  right: 0;
}

button:focus {
  border: 1px solid var(--neutral-700);
  outline: none;
}

svg {
  color: var(--neutral-400);
  height: 20px;
  width: 20px;
}

button:hover > svg,
button:focus > svg {
  color: var(--neutral-700);
}
</style>
