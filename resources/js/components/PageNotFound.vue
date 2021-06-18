<template>
  <div>
    <Navbar />
    <div class="absolute inset-0 bg-gray-200 flex items-center justify-center">
      <div class="text-3xl text-center text-red-600">
        Page Not Found! <br />404 ERROR!
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
};
</script>