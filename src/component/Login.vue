<template>
  <div class="text-center maindiv d-flex justify-content-center">
    <div class="card-q">
      <b-card>
        <main class="form-signin">
          <h1 class="h3 mb-3 fw-normal">Please enter your name</h1>

          <div class="form-floating">
            <input
              type="text"
              class="form-control"
              id="floatingInput"
              placeholder="Your name"
              v-model="userName"
              required
            v-on:change="unlock()"
            />
          </div>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me" /> Remember me
            </label>
          </div>
          <button
            class="w-100 btn btn-lg btn-primary"
            :disabled="disabled"
            @click="login()"
          >
            Next
          </button>
          <p class="mt-5 mb-3 text-muted">&copy;2021</p>
        </main>
      </b-card>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  data() {
    return {
      disabled: true,
      userName: "",
    };
  },
  methods: {
    login() {
      console.log(this.userName);
      this.$emit("logIn", this.userName);
    },
    unlock() {
      console.log(this.userName)
      if ($(this.userName.length < 0)) this.disabled = false;
    },
  },
};
</script>
    <style scoped>
.card {
  min-width: 100%;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 10px 10px 42px 0px rgba(0, 0, 0, 0.75);
}
.card-q {
  min-width: 60%;
}
</style>