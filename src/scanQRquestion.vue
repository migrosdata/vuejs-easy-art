<template>
  <div v-if="!isValid">
    <b-card title="" style="max-width: 20rem" class="mb-3" img-top>
      <qrcode-stream @decode="onDecode" :track="this.paintOutline">
        <div v-if="validationSuccess" class="validation-success">question found</div>

        <div v-if="validationFailure" class="validation-failure">question not found</div>

        <div v-if="validationPending" class="validation-pending">
          Scanning...
        </div>
      </qrcode-stream>

      <b-card-text> Scan your question</b-card-text>
    <b-button @click="back" variant="info">Back</b-button>
    
      <b-card-text> </b-card-text>
      <b-card-text> </b-card-text>
    </b-card>
  </div>
  <div class="card-q" v-else>
    <div v-if="questions[currentQuestion].questionType === 'qrquestion'">
    
    </div>
    <div
      v-else-if="questions[currentQuestion].questionType === 'imagequestion'"
    >
      <b-card
        title="Simple Quiz Application"
        style="max-width: 20rem"
        class="mb-3"
        img-top
      >
        <Pixel
          :imgUrl="`${questions[currentQuestion].questionMedias[2].src}`"
          v-if="
            questions[currentQuestion].questionMedias[2].filter == 'pixelise'
          "
          :difficulty="questions[currentQuestion].difficulty"
        />
        <Flash
          :imgUrl="`${questions[currentQuestion].questionMedias[2].src}`"
          v-else-if="
            questions[currentQuestion].questionMedias[2].filter == 'flash'
          "
        />

        <b-img
          v-else
          :src="
            require(`./assets/${questions[currentQuestion].questionMedias[2].src}`)
          "
          alt="Image"
          fluid
          thumbnail
          id="img"
        ></b-img>
        <div id="videoContainer" class="box"></div>
        
        <b-card-text>
          Question No.{{ currentQuestion}}
        </b-card-text>
        <br />
      

       
        <b-card-text>
          {{ questions[currentQuestion].questionText }}
        </b-card-text>
        <div class="answer-section">
          <b-button
            :key="index"
            v-for="(option, index) in questions[currentQuestion].answerOptions"
            @click="handleAnswerClick(option.isCorrect)"
            class="ans-option-btn"
            variant="primary"
            >{{ option.answerText }}</b-button
          >
        </div>
      </b-card>
    </div>
    <div v-else>
      <b-card
        title="Simple Quiz Application"
        style="max-width: 20rem"
        class="mb-3"
        img-top
      >
        <b-embed type="video" aspect="4by3" controls poster="poster.png">
          <source src="dev-stories.webm" type="video/webm" />
          <source
            :src="
              require(`./assets/${questions[currentQuestion].questionMedias[0].src}`)
            "
            type="video/mp4"
          />
        </b-embed>
        <b-card-text>
          Question No.{{ currentQuestion + 1 }} of {{ questions.length }}
        </b-card-text>
        <br />
        <b-progress
          variant="warning"
          :max="30"
        
          height="4px"
        ></b-progress>

      
        <b-card-text>
          {{ questions[currentQuestion].questionText }}
        </b-card-text>
        <div class="answer-section">
          <b-button
            :key="index"
            v-for="(option, index) in questions[currentQuestion].answerOptions"
            @click="handleAnswerClick(option.isCorrect)"
             data-target="#incorrectModal" 
            class="ans-option-btn"
            variant="primary"
            >{{ option.answerText }}</b-button
          >
        </div>
      </b-card>
    </div>

    <b-modal ref="incorrectModal" id="incorrectModal" hide-footer title="Incorrect Answear">
      <div class="d-block text-center">
        <h3>Incorrect Answear!</h3>
      </div>
      <b-button class="mt-3">Close</b-button>
    </b-modal>
  </div>
</template>



<script>
import Pixel from "./Pixel.vue";
import $ from "jquery";
import Flash from "./Flashlight.vue";
import Form from "./Form.vue";
import QRreader from "./QRreader.vue";
import VideoPlayer from "./component/VideoPlayer.vue";
import { QrcodeStream } from "vue-qrcode-reader";
export default {
  props: {
    questions: { type: Array, required: true },
  },
  components: {
    Pixel,
    Flash,
  
    QrcodeStream,
  },
  data() {
    return {
      currentQuestion: 0,
      showScore: false,
      score: 0,
    
      timer: null,
      scanValid: false,

      videoOptions: {
        autoplay: true,
        controls: true,
      },
      camera: "auto",
      result: null,
      showScanConfirmation: false,
      showModal: false,
      isValid: undefined,
    };
  },
  created: function () {},
  computed: {
    validationPending() {
      return this.isValid === undefined && this.camera === "off";
    },

    validationSuccess() {
      return this.isValid === true;
    },

    validationFailure() {
      return this.isValid === false;
    },
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
    paintOutline(detectedCodes, ctx) {
      for (const detectedCode of detectedCodes) {
        const [firstPoint, ...otherPoints] = detectedCode.cornerPoints;

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
      console.log(this.result);
      var selectedQuestion = this.questions.filter((obj) => {
        return obj.id == this.result;
      });

     console.log(selectedQuestion);
      if (selectedQuestion!=null) {
        this.isValid = true
        console.log("index",this.findWithAttr(this.questions,'id',selectedQuestion[0].id))
         this.currentQuestion= this.findWithAttr(this.questions,'id',selectedQuestion[0].id)
             console.log(this.currentQuestion);
      } else {
        this.isValid = false;
        
      }

      this.pause();
      await this.timeout(500);
      this.unpause();
    
    },

    unpause() {
      this.camera = "auto";
    },

    pause() {
      this.camera = "off";
    },
 back: function () {
      this.$emit("back");
    },
    timeout(ms) {
      return new Promise((resolve) => {
        window.setTimeout(resolve, ms);
      });
    },
    startQuizFunc() {
      this.startQuiz = true;
  
    },
    handleAnswerClick(isCorrect) {
      clearTimeout(this.timer);
      let nextQuestion = this.currentQuestion;
      if (isCorrect) {
    this.$emit("setscanQuestion");
      }
      if (nextQuestion < this.questions.length) {
    this.$refs.incorrectModal.show()
       
      
      } else {
        // localStorage.removeItem('qattended')
        this.showScore = true;
        // localStorage.setItem('testComplete',this.showScore)

       
      }
    },
  
    addQuestionFunc() {
      this.addQuestion = true;
    },
  findWithAttr(array, attr, value) {
    for(var i = 0; i < array.length; i += 1) {
        if(array[i][attr] === value) {
            return i;
        }
    }
    return -1;
}
  },
};
</script>

<style scoped>
.span {
  min-width: 100%;
}
.card {
  min-width: 100%;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 10px 10px 42px 0px rgba(0, 0, 0, 0.75);
}
.card-q {
  min-width: 100%;
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
/* .ans-option-btn {
  width: 100%;
  font-size: 16px;
  color: #ffffff;
  background-color: #252d4a;
  border-radius: 15px;
  display: flex;
  padding: 5px;
  justify-content: flex-start;
  align-items: center;
  border: 5px solid #234668;
  cursor: pointer;
} */
</style>
