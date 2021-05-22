<template>
  <div class="content-wrap" @mousemove="mouseMove">
    <div class="img-wrapper">
      <img src="https://media.timeout.com/images/105590782/750/422/image.jpg" />
    </div>
    <div class="hover-overlay"></div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  mounted() {
    // document.getElementsByClassName("content-wrap")[0].addEventListener('mousemove',this.update)
    // resize the flashlight on time
    
  },

  data() {
    return {
      rgbaP1: 5,
      rgbaP2: 10,
      polling: null,
      transform:null,
    };
  },
  methods: {
    pollData() {
      this.polling = setInterval(() => {
        this.rgbaP1 = this.rgbaP1 - 1;
        this.rgbaP2 = this.rgbaP2 - 1;

        console.log(this.rgbaP1);


        let bg =
          `background:radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)` +
          this.rgbaP1 +
          `%,
    rgba(19, 19, 19, 0.959) ` +
          this.rgbaP2 +
          `%,
    #000000 100%
  );`;

        document.getElementsByClassName("hover-overlay")[0].style = bg;
        
        let overlay = document.querySelector(".hover-overlay");
        overlay.style.transform =   this.transform;
      }, 3000);
    },
    
    mouseMove(e) {
      const images = document.querySelectorAll(".img-wrapper");

      let overlay = document.querySelector(".hover-overlay");

      let posX = e.clientX;
      let posY = e.clientY;
      const container = $(".content-wrap");
      let containerwidth = container.width();
      let containerheigh = container.height();

      let width = containerwidth * 2;
      let heigh = containerheigh * 2;
      overlay.style.width = containerwidth + width + "px";

      overlay.style.height = containerheigh + heigh + "px";
      overlay.style.transform =
        "translate(calc(" +
        posX +
        "px - " +
        width +
        "px), " +
        "calc(" +
        posY +
        "px - " +
        heigh +
        "px))";
        this.transform=   overlay.style.transform;
    },
  },
};
</script>

<style scoped>
/* Flashlight Overlay */
.content-wrap {
  width: 80%;

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
.content-wrap div {
  display: inline-block;
  position: relative;
}
.hover-overlay {
  position: absolute;
  background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034) 5%,
    rgba(19, 19, 19, 0.959) 10%,
    #000000 100%
  );
  width: 1200px;
  height: 1200px;
  transform: translate(0, 0);
  top: 0;
  left: 0;
  border-radius: 100%;
  animation: colorChange 33s infinite alternate;
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
@keyframes colorChange {
 
  0% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034) 4.7%,
    rgba(19, 19, 19, 0.959) 9.7%,
    #000000 100%
  )
  }
   5% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034) 4.5%,
    rgba(19, 19, 19, 0.959) 9.5%,
    #000000 100%
  )
  }
   10% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034) 4.2%,
    rgba(19, 19, 19, 0.959) 9.1%,
    #000000 100%
  )
  }
    15% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034) 4%,
    rgba(19, 19, 19, 0.959) 8.8%,
    #000000 100%
  )
  }
   30% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)3.8%,
    rgba(19, 19, 19, 0.959) 8.5%,
    #000000 100%
  )
  }
     35% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)3.8%,
    rgba(19, 19, 19, 0.959) 8.5%,
    #000000 100%
  )
  }
     40% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)3.5%,
    rgba(19, 19, 19, 0.959) 8.3%,
    #000000 100%
  )
  }
     45% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)3.2%,
    rgba(19, 19, 19, 0.959) 8%,
    #000000 100%
  )
  }
    50% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)3%,
    rgba(19, 19, 19, 0.959) 7.8%,
    #000000 100%
  )
  }
  55% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)2.8%,
    rgba(19, 19, 19, 0.959) 7.5%,
    #000000 100%
  )
  }
   60% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)2.5%,
    rgba(19, 19, 19, 0.959) 7.2%,
    #000000 100%
  )
  }
  65% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)2.2%,
    rgba(19, 19, 19, 0.959) 6.9%,
    #000000 100%
  )
  }
   70% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)1.5%,
    rgba(19, 19, 19, 0.959)6.5%,
    #000000 100%
  )
  }
   75% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)1%,
    rgba(19, 19, 19, 0.959)6%,
    #000000 100%
  )
  }
   80% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)0.5%,
    rgba(19, 19, 19, 0.959)5%,
    #000000 100%
  )
  }
   90% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)0%,
    rgba(19, 19, 19, 0.959)5%,
    #000000 100%
  )
  }
     90% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)0%,
    rgba(19, 19, 19, 0.959)2.5%,
    #000000 100%
  )
  }
   95% {
    background: radial-gradient(
    circle at center,
    rgba(255, 255, 255, 0.034)0%,
    rgba(19, 19, 19, 0.959)0%,
    #000000 100%
  )
  }
 }
</style>
