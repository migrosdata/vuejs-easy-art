<template>
  <div class="content-wrap" id="flash-area" @mousemove="mouseMove">
    <div class="img-wrapper">
      <img
        src="https://media.timeout.com/images/105590782/750/422/image.jpg"
      />
    </div>
    <div class="hover-overlay"></div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  mounted() {
    // document.getElementsByClassName("content-wrap")[0].addEventListener('mousemove',this.update)
  },
  methods: {
    mouseMove(e) {
      const overlay = document.querySelector('.hover-overlay');
      let posX = e.clientX;
      let posY = e.clientY;
      overlay.style.transform =
        "translate(calc(" +
        posX +
        "px - 800px), " +
        "calc(" +
        posY +
        "px - 800px))";
    },
  },
};
</script>

<style scoped>
/* Flashlight Overlay */
.content-wrap {

  width: 100%;

  margin: 0 auto;
  position: relative;
  overflow: hidden;
 
}
img {
  margin: 20px;
}
.content-wrap .hover-overlay {
  position: absolute;
}
.overlay {
  position: absolute;
  width: 50px;
  height: 50px;
  top: 5px;
  left: 5px;
  background-color: rgba(0, 0, 0, 0.5);
  transition: background-color 0.15s ease;
}
.hover-overlay {
  position: absolute;
  width: 1200px;
  height: 1200px;
  background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034) 5%,
    rgba(19, 19, 19, 0.959) 10%,
    #000000 100%
  );
  transform: translate(0, 0);
  top: 0;
  left: 0;
  border-radius: 50%;
}
#flashlight {
  background: url(https://s3.amazonaws.com/ip-devs/AllState/keep-your-sanity/img/flashlight.png)
    center center no-repeat;
  position: absolute;
  z-index: 999;
  height: 1046px;
  width: 1920px;
  pointer-events: none;
}
</style>
