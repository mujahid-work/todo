<template>
  <div>
    <Navbar />
    <div class="flex flex-wrap w-full justify-center items-center pt-10">
      <div class="flex flex-wrap max-w-xl">
        <div class="p-2 text-2xl text-gray-800 font-semibold">
          <h1>Create a new todo</h1>
        </div>
        <div class="p-2 w-full">
          <label for="title">Title</label>
          <input
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
            "
            placeholder="enter title of your todo"
            type="text"
            v-model="form.title"
          />
          <span class="w-full text-red-500" v-if="errors.title">{{
            errors.title[0]
          }}</span>
        </div>
        <div class="p-2 w-full">
          <label for="description">Description</label>
          <textarea
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
            "
            placeholder="enter short description"
            v-model="form.description"
            name="description"
          ></textarea>
          <span class="w-full text-red-500" v-if="errors.description">{{
            errors.description[0]
          }}</span>
        </div>
        <div class="p-2 w-full mt-4">
          <button
            @click.prevent="save"
            type="submit"
            class="
              flex
              text-white
              bg-indigo-500
              border-0
              py-2
              px-8
              focus:outline-none
              hover:bg-indigo-600
              rounded
              text-lg
            "
          >
            Save
          </button>
        </div>
      </div>
    </div>
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
      form: {
        title: "",
        description: "",
      },
      errors: [],
    };
  },
  methods: {
    save() {
      axios
        .post("/api/todo", this.form)
        .then((response) => {
          this.$router.push({ name: "list" });
          this.$toaster.success(response.data.success[0]);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          if (this.errors.error) {
            this.$toaster.error(this.errors.error[0]);
          }
        });
    },
  },
};
</script>