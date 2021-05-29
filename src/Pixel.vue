<template>
  <div>
    
    <!-- Canvas -->
    <canvas id="c"></canvas>
    <!-- Add Rectangle Button -->
    <div></div>
  </div>
</template>

<script>
export default {
  props: {
    imgUrl: {
      type: String,
      required: true,
    },
  },

  watch: {
    imgUrl: function (val, oldVal) {
      console.log("new: %s, old: %s", val, oldVal);
      var canvas = document.getElementById("c");
      var ctx = canvas.getContext("2d");
      this.vueCanvas = ctx;
      let img = new Image();
      // turn off image smoothing - this will give the pixelated effect
      ctx.mozImageSmoothingEnabled = false;
      ctx.webkitImageSmoothingEnabled = false;
      ctx.imageSmoothingEnabled = false;

      // wait until image is actually available
      img.onload = pixelate;

      // some image, we are not struck with CORS restrictions as we
      // do not use pixel buffer to pixelate, so any image will do
      img.src = require(`./assets/${val}`) 
      console.log(img.src)
      

      // MAIN function
      function pixelate(v) {
        // if in play mode use that value, else use slider value
        var size = 10 * 0.01,
          // cache scaled width and height
          w = canvas.width * size,
          h = canvas.height * size;

        console.log(size);
        // draw original image to the scaled size
        ctx.drawImage(img, 0, 0, w, h);

        // then draw that scaled image thumb back to fill canvas
        // As smoothing is off the result will be pixelated
        ctx.drawImage(canvas, 0, 0, w, h, 0, 0, canvas.width, canvas.height);
      }

      // poly-fill for requestAnmationFrame with fallback for older
      // browsers which do not support rAF.
      
    },
  },
  mounted() {  
   
      var canvas = document.getElementById("c");
      var ctx = canvas.getContext("2d");
      this.vueCanvas = ctx;
      let img = new Image();
      // turn off image smoothing - this will give the pixelated effect
      ctx.mozImageSmoothingEnabled = false;
      ctx.webkitImageSmoothingEnabled = false;
      ctx.imageSmoothingEnabled = false;

      // wait until image is actually available
      img.onload = pixelate;

      // some image, we are not struck with CORS restrictions as we
      // do not use pixel buffer to pixelate, so any image will do
      img.src = require(`./assets/${this.imgUrl}`) 
      console.log(img.src)
      

      // MAIN function
      function pixelate(v) {
        // if in play mode use that value, else use slider value
        var size = 10 * 0.01,
          // cache scaled width and height
          w = canvas.width * size,
          h = canvas.height * size;

        console.log(size);
        // draw original image to the scaled size
        ctx.drawImage(img, 0, 0, w, h);

        // then draw that scaled image thumb back to fill canvas
        // As smoothing is off the result will be pixelated
        ctx.drawImage(canvas, 0, 0, w, h, 0, 0, canvas.width, canvas.height);
      }},
  methods: {
    drawRect() {},
  },
};
</script>

<style scoped>
canvas {
  width: 100%;
  image-rendering: optimizeSpeed;
  image-rendering: -moz-crisp-edges;
  image-rendering: -webkit-optimize-contrast;
  image-rendering: -o-crisp-edges;
  image-rendering: crisp-edges;
  -ms-interpolation-mode: nearest-neighbor;
}
</style>
