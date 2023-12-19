<script setup>
import {computed, watch, onMounted, ref} from "vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import TaskLayout from "@/Layouts/TaskLayout.vue";
import RequestHelper from "@/Helpers/RequestHelper";
import {notify} from "@kyvg/vue3-notification";

let tasks = ref({});
const user = usePage().props.value.auth.user;
let blockLoading = false;
let lastTaskId = null;
let request = new RequestHelper();

const props = defineProps({
  tasksProp: {
    default: []
  }
});

tasks.value = props.tasksProp;

watch(() => props.tasksProp, (newValue) => {
  tasks.value = newValue;
});

const form = useForm({
    text: '',
});

const scrollToBottom = () => {
    setTimeout(() => {
        let topPos = document.getElementById('inner-element').offsetTop;
        document.getElementById('container').scrollTop = topPos - 10;
    }, 1);
}

const loadTasks = async (initialLoad = false) => {
    let url = '/tasks';
    if (!initialLoad && lastTaskId) {
        url += '?task_id=' + lastTaskId;
    }
    let response = await request.get(url, "Can't load tasks");

    if (response.error) {
        return false;
    }

    tasks.value = {...response.data.data, ...tasks.value};

    if (response.data.data) {
        setTimeout(() => {
            blockLoading = false
        }, 500);
    }
}

const sendTask = async () => {
  form.post(route('tasks.store'));
  form.text = '';
}

const toggleEdit = (id) => {
  if (!tasks.value[id].editing) {
    tasks.value[id].newText = tasks.value[id].text;
    tasks.value[id].editing = true;
  } else {
    tasks.value[id].editing = false;
  }
}

const doTask = async (id, done = true) => {
  const errorMessage = 'Error! Could not update task status: ' + tasks.value[id].text;
  const response = await request.patch(route('tasks.update', {id}), {done}, errorMessage);

  if (response.error) {
    tasks.value[id].done = !done;
  }
}

const updateText = async (task) => {
  const id = task.id;
  const text = task.newText;
  if (!text) {
    notify({
      title: "Input error",
      text: "Task's text can't be empty",
      type: 'error'
    });
    return false;
  }

  const errorMessage = 'Error! Could not update task text: ' + text;
  const response = await request.patch(route('tasks.update', {id}), {text}, errorMessage);

  if (!response.error) {
    tasks.value[id].text = text;
    toggleEdit(id);
  }
}

const deleteTask = async (id) => {
  const errorMessage = 'Error! Could not delete task: ' + tasks.value[id].text;
  const response = await request.delete(route('tasks.destroy', {id}), errorMessage);
  if (!response.error) {
    delete tasks.value[id];
  }
}

const formError = computed(() => {
    if (form.errors.text) {
        return form.errors.text;
    }

    if (!form.text || form.text.length <=500) {
        return '';
    }
    return 'Max task size is 500.';
});

const clearErrors = () => {
    form.clearErrors();
}

onMounted(() => {
    // loadTasks(true);
});

</script>

<template>
  <TaskLayout>
    <template #default>
      <div class="container mt-4">
        <form @submit.prevent="sendTask">
          <div class="d-flex align-items-center p-2 pt-4">
            <textarea
                class="form-control mr-3 bg-dark text-white max-w-md"
                v-model="form.text"
                @keyup.enter.exact="sendTask"
                @input="clearErrors"
                maxlength="500"
                placeholder="Type new task here"
            ></textarea>
            <button
                type="submit"
                class="btn btn-primary"
            >
              Send
            </button>
          </div>
        </form>
        <div class="text-danger w-100 bg-dark p-2" v-if="formError">{{ formError }}</div>

        <div class="form-check mt-6" v-for="(task) in tasks" :key="task.id">
          <input
              class="form-check-input mr-2"
              type="checkbox"
              v-model="task.done"
              :id="'task' + task.id"
              @change="doTask(task.id, task.done)"
          />
          <label class="form-check-label" :for="'task' + task.id" v-if="!task.editing">
            {{ task.text }}
          </label>

          <input type="text" v-if="task.editing" v-model="task.newText" class="form-control mb-2">
          <button class="btn btn-success ml-2" v-if="task.editing" @click="updateText(task)">Save</button>
          <span title="edit" class="right-icon" @click="toggleEdit(task.id)">✎</span>
          <span title="delete" class="right-icon" @click="deleteTask(task.id)">⛌</span>
        </div>
      </div>
    </template>
  </TaskLayout>
</template>

<style scoped>

.right-icon {
  opacity: .5;
  margin-left: .7rem;
  cursor: pointer;
  color: yellow;
}

.right-icon:hover {
  opacity: 1;
}

</style>
