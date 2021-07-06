<template>
  <div>
    <Navbar />
    <div class="flex flex-wrap w-full justify-center items-center pt-10">
      <div class="flex flex-wrap max-w-xl">
        <div class="p-2 text-2xl text-gray-800 font-semibold">
          <h1>Verify your account</h1>
        </div>
        <div class="p-2 w-full">
          <label for="email">Verification Code</label>
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
            placeholder="enter your verification code"
            type="text"
            v-model="form.code"
          />
          <span class="w-full text-red-500" v-if="errors.code">{{
            errors.code[0]
          }}</span>
        </div>
        <div class="p-2 w-full mt-4">
          <button
            @click.prevent="verifyAccount"
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
            Verify Account
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
        code: "",
      },
      user_id: null,
      errors: [],
    };
  },
  methods: {
    verifyAccount() {
      axios
        .post("/api/verify-account", this.form)
        .then((response) => {
          this.$router.push({ name: "login" });
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