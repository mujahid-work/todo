<template>
  <div>
    <Navbar />
    <div class="container my-12 mx-auto px-4 md:px-12">
      <div class="text-2xl text-green-600 font-bold">
        <input
          type="text"
          v-model="keywords"
          class="
            w-full
            bg-gray-100
            rounded
            border border-gray-400
            focus:outline-none
            focus:border-indigo-500
            text-base
            px-4
            py-2
            mb-10
          "
          placeholder="enter keywords to search"
        />
        <p v-if="user">My ToDo List:</p>
        <p v-else>All ToDo:</p>
      </div>
      <div class="flex flex-wrap -mx-1 lg:-mx-4" v-if="todo_list.data.length">
        <div
          class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3"
          v-for="todo in todo_list.data"
          :key="todo.id"
        >
          <article class="overflow-hidden rounded-lg shadow-lg bg-gray-50">
            <header
              class="flex items-center justify-between leading-tight p-2 md:p-4"
            >
              <h1 class="text-lg">{{ todo.title }}</h1>
              <p class="text-grey-darker text-sm">
                {{ moment(String(todo.created_at)).format("MM/DD/YYYY") }}
              </p>
            </header>
            <p class="text-grey-darker text-sm ml-4">{{ todo.description }}</p>
            <footer
              class="flex items-center justify-between leading-none p-2 md:p-4"
            >
              <a
                class="
                  flex
                  items-center
                  no-underline
                  hover:underline
                  text-black
                "
                href="#"
              >
                <p class="ml-2 text-sm"></p>
              </a>

              <div class="btn-group" role="group" v-if="user !== false">
                <router-link
                  :to="{ name: 'view', params: { id: todo.id } }"
                  class="btn btn-primary"
                >
                  <font-awesome-icon class="text-green-600" icon="edit" />
                </router-link>
                <button
                  class="
                    text-white
                    px-3
                    py-2
                    text-sm
                    font-medium
                    focus:outline-none
                  "
                  @click="deleteTodo(todo.id)"
                >
                  <font-awesome-icon class="text-red-600" icon="trash" />
                </button>
              </div>
            </footer>
          </article>
        </div>
      </div>
      <div class="text-3xl text-center text-red-600" v-if="!todo_list.data.length">
        No Record Found! <br />
      </div>
      <pagination
        class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
        :data="todo_list"
        @pagination-change-page="getResults"
      ></pagination>
    </div>
  </div>
</template>
<script>
import Navbar from "./Navbar";
var moment = require("moment");
export default {
  components: {
    Navbar,
  },
  data() {
    return {
      moment: moment,
      user: false,
      todo_list: null,
      keywords: null,
    };
  },
  watch: {
    keywords() {
      this.getResults();
    },
  },
  methods: {
    deleteTodo(id) {
      axios
        .delete(`/api/todo/${id}`)
        .then((response) => {
          let i = this.todo_list.data.map((todo) => todo.id).indexOf(id); // find index of your object
          this.todo_list.data.splice(i, 1);
          this.$toaster.success(response.data.success[0]);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          if (this.errors.error) {
            this.$toaster.error(this.errors.error[0]);
          }
        });
    },
    getResults(page = 1) {
      axios
        .get("/api/todo", { params: { keywords: this.keywords, page: page } })
        .then((response) => {
          this.todo_list = response.data;
        });
    },
  },
  mounted() {
    axios.get("/api/user").then((response) => {
      this.user = response.data;
    });
    this.getResults();
  },
};
</script>