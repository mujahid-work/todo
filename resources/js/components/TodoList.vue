<template>
  <div>
    <Navbar />
    Todo List
  </div>
</template>
<script>
import Navbar from "./Navbar";
export default {
  components: {
    Navbar,
  },
  data() {
    return {
      user: false,
      todo_list: null,
      url: null,
    };
  },
  methods: {
    fetchTodoList(path) {
      axios.get(path).then((response) => {
        this.todo_list = response.data;
      });
    },
  },
  mounted() {
    // axios.get("/api/user").then((response) => {
    //   this.user = response.data;
    // });
    // this.user
    //   ? (this.url = "api/todo/" + this.user.id)
    //   : (this.url = "api/todo");
    // fetchTodoList(this.url);

    this.fetchTodoList('api/todo');
  },
};
</script>