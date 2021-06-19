<template>
  <b-card
    title=""
    style="max-width: 20rem"
    class="mb-3"
    img-top
  >
    <qrcode-stream @decode="onDecode" :track="this.paintOutline">

 <div v-if="validationSuccess" class="validation-success">
       Correct
      </div>

      <div v-if="validationFailure" class="validation-failure">
     Incorrect
      </div>

      <div v-if="validationPending" class="validation-pending">
      Scanning...
      </div>

    </qrcode-stream>

    <b-card-text>    {{ questionText }}</b-card-text>
     <b-button
            class="ans-option-btn"
            variant="primary"
              @click="onDecode(-1)"
            >I am layz
            
            </b-button
          >
    <br />
    <b-progress
      variant="warning"
      :max="30"
      :value="countDown"
      height="4px"
    ></b-progress>

    <b-card-text>
      
   </b-card-text>
    <b-card-text>
   
    </b-card-text>
    <b-modal id="modal modal-active" title="BootstrapVue" v-if="showModal">
      <p class="my-4">Hello from modal!</p>
    </b-modal>
    
  </b-card>
</template>

<script>
import { QrcodeStream } from "vue-qrcode-reader";
import $ from "jquery";
export default {
  components: { QrcodeStream },
  props: {
    currentQuestion: String,
    questionText: String,
    questionMedias: Array,
    multiple_correct_answers: Boolean,
    answerOptions: Array,
    questionId:String
    //category: String,
    //difficulty: String,
  },
  data() {
    return {
      camera: "auto",
      result: null,
      showScanConfirmation: false,
      showModal:false,
        isValid: undefined,

    };
  },
computed: {
    validationPending () {
      return this.isValid === undefined
        && this.camera === 'off'
    },

    validationSuccess () {
      return this.isValid === true
    },

    validationFailure () {
      return this.isValid === false
    }
  },
  methods: {
    async onInit(promise) {
      try {
        await promise;
      } catch (e) {
        console.error(e);
      } finally {
        this.showScanConfirmation = this.camera === "off";
      }
    },
  paintOutline (detectedCodes, ctx) {
      for (const detectedCode of detectedCodes) {
        const [ firstPoint, ...otherPoints ] = detectedCode.cornerPoints

        ctx.strokeStyle = "red";

        ctx.beginPath();
        ctx.moveTo(firstPoint.x, firstPoint.y);
        for (const { x, y } of otherPoints) {
          ctx.lineTo(x, y);
        }
        ctx.lineTo(firstPoint.x, firstPoint.y);
        ctx.closePath();
        ctx.stroke();
      }
    },
    async onDecode(content) {
      this.result = content;
      console.log(content);

 
 if(this.result==this.questionId)
 {
       this.isValid = true
         
 }
 else   {
   this.isValid = false
 
 }

 
      this.pause();
      await this.timeout(500);
      this.unpause();
      this.$emit("handleAnswerClick", this.isValid);
    },

    unpause() {
      this.camera = "auto";
    },

    pause() {
      this.camera = "off";
    },

    timeout(ms) {
      return new Promise((resolve) => {
        window.setTimeout(resolve, ms);
      });
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
.ans-option-btn {
  min-width: 50%;
  font-size: 16px;
  color: #ffffff;
  align-items: center;
  cursor: pointer;
  margin-bottom: 5px;
}
.answer-section {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.timer-text {
  background: rgb(230, 153, 12);
  padding: 15px;
  margin-top: 20px;
  margin-right: 20px;
  border: 5px solid rgb(255, 189, 67);
  border-radius: 15px;
  text-align: center;
}
.card-img,
.card-img-top {
  border-top-left-radius: calc(0.25rem - 1px);
  border-top-right-radius: calc(0.25rem - 1px);
  height: 350px;
}
canvas {
  image-rendering: optimizeSpeed;
  image-rendering: -moz-crisp-edges;
  image-rendering: -webkit-optimize-contrast;
  image-rendering: -o-crisp-edges;
  image-rendering: crisp-edges;
  -ms-interpolation-mode: nearest-neighbor;
}
.scan-confirmation {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, 0.8);

  display: flex;
  flex-flow: row nowrap;
  justify-content: center;
}
.validation-success,
.validation-failure,
.validation-pending {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, .8);
  text-align: center;
  font-weight: bold;
  font-size: 1.4rem;
  padding: 10px;

  display: flex;
  flex-flow: column nowrap;
  justify-content: center;
}
.validation-success {
  color: green;
}
.validation-failure {
  color: red;
}
</style>