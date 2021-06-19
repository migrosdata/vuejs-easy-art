<template>
  <div class="text-center maindiv d-flex justify-content-center">
    <div class="card-q">
      <b-card>
        <main class="form-signin">
          <h2 class="text-center">Sign in</h2>

          <div class="form-floating">
            <input
              type="text"
              class="form-control mb-3"
              id="floatingInput"
              placeholder="Your name"
              v-model="userName"
              required
              v-on:change="unlock()"
            />
          </div>

          <button
            class="w-100 btn btn-success btn-block login-btn"
            :disabled="disabled"
            @click="login()"
          >
            Sign in
          </button>
          <div class="or-seperator"><i>or</i></div>
          <div class="text-center social-btn">
            <a href="#" class="btn btn-primary btn-block"
              ><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a
            >
            <a href="#" class="btn btn-info btn-block"
              ><i class="fa fa-twitter"></i> Sign in with <b>Twitter</b></a
            >
            <a href="#" class="btn btn-danger btn-block"
              ><i class="fa fa-google"></i> Sign in with <b>Google</b></a
            >
          </div>
          <div class="clearfix">
            <label class="pull-left checkbox-inline"
              ><input type="checkbox" /> Remember me</label
            >
            <a href="#" class="pull-right text-success">About us</a>
          </div>
          <p class="mt-5 mb-3 text-muted">easyart&copy;2021</p>
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
      console.log(this.userName);
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
.social-btn .btn {
  margin: 10px 0;
  font-size: 15px;
  text-align: left;
  line-height: 24px;
}
.social-btn .btn i {
  float: left;
  margin: 4px 15px 0 5px;
  min-width: 15px;
}
.or-seperator {
  margin: 20px 0 10px;
  text-align: center;
  border-top: 1px solid #ccc;
}
.or-seperator i {
  padding: 0 10px;
  background: #f7f7f7;
  position: relative;
  top: -11px;
  z-index: 1;
}
</style>