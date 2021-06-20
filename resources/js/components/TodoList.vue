<template>
  <div>
    <Navbar />
    <div class="container my-12 mx-auto px-4 md:px-12">
      <div class="text-2xl text-green-600 font-bold">
        <p v-if="user">My ToDo List:</p>
        <p v-else>All ToDo:</p>
      </div>
      <div class="flex flex-wrap -mx-1 lg:-mx-4" v-if="todo_list.length">
        <div
          class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3"
          v-for="todo in todo_list"
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
                <p class="ml-2 text-sm">Author Name</p>
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
      <div class="text-3xl text-center text-red-600" v-if="!todo_list.length">
        No Record Found! <br />
      </div>
    </div>
    <!-- <pagination
      :data="todo_list"
      @pagination-change-page="getResults"
    ></pagination> -->
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
      url: null,
    };
  },
  methods: {
    deleteTodo(id) {
      axios
        .delete(`/api/todo/${id}`)
        .then((response) => {
          let i = this.todo_list.map((todo) => todo.id).indexOf(id); // find index of your object
          this.todo_list.splice(i, 1);
          this.$toaster.success(response.data.success[0]);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          if (this.errors.error) {
            this.$toaster.error(this.errors.error[0]);
          }
        });
    },
    fetchTodoList(path) {
      axios.get(path).then((response) => {
        console.log(response.data);
        this.todo_list = response.data.data;
      });
    },
    // getResults(page) {
    //   if (typeof page === "undefined") {
    //     page = 1;
    //   }
    //   axios.get("api/todo?page=" + page)
    //     .then((response) => {
    //       return response.json();
    //     })
    //     .then((data) => {
    //       debugger
    //       this.todo_list = data;
    //     });
    // },
  },
  mounted() {
    axios.get("/api/user").then((response) => {
      this.user = response.data;
    });
    this.user
      ? (this.url = "api/todo/user-list/" + this.user.id)
      : (this.url = "api/todo");
    this.fetchTodoList(this.url);

    // this.fetchTodoList("api/todo");
    // this.getResults();
  },
};
</script>