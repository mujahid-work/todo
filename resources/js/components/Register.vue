<template>
  <div>
    <Navbar />
    <div class="flex flex-wrap w-full justify-center items-center pt-10">
      <div class="flex flex-wrap max-w-xl">
        <div class="p-2 text-2xl text-gray-800 font-semibold">
          <h1>Register an account</h1>
        </div>
        <div class="p-2 w-full">
          <label class="w-full" for="name">Name</label>
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
            placeholder="enter your full name"
            type="text"
            v-model="form.name"
          />
          <span class="w-full text-red-500" v-if="errors.name">{{
            errors.name[0]
          }}</span>
        </div>
        <div class="p-2 w-full">
          <label for="email">Your Email</label>
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
            placeholder="enter you email address"
            type="email"
            v-model="form.email"
          />
          <span class="w-full text-red-500" v-if="errors.email">{{
            errors.email[0]
          }}</span>
        </div>
        <div class="p-2 w-full">
          <label for="password">Password</label>
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
            placeholder="enter your password"
            type="password"
            v-model="form.password"
            name="password"
          />
          <span class="w-full text-red-500" v-if="errors.password">{{
            errors.password[0]
          }}</span>
        </div>
        <div class="p-2 w-full">
          <label for="confirm_password">Confirm Password</label>
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
            placeholder="confirm your password"
            type="password"
            v-model="form.password_confirmation"
            name="password_confirmation"
          />
        </div>
        <div class="p-2 w-full mt-4">
          <button
            @click.prevent="saveForm"
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
            Register
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
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: [],
    };
  },
  methods: {
    saveForm() {
      axios
        .post("/api/register", this.form)
        .then((response) => {
          this.$router.push({ name: "verify" });
          this.$toaster.success(response.data.success[0]);
        })
        .catch((error) => {
          this.errors = error.response.data.error;
          if (this.errors) {
            this.$toaster.error(this.errors[0]);
          }
        });
    },
  },
};
</script>