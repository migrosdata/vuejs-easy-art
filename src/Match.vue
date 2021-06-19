<template>
  <div class="card-q" v-if="matchstarted">
    <b-row class="text-center bg-white">
      <b-col
        >{{ userName }}
        <h6
          :key="index"
          v-for="(option, index) in myAnswear"
           :class="option.color"
     
          >{{ option.text }}</h6
        ></b-col
      >
      <b-col cols="8">
        <div v-if="questions[currentQuestion].questionType === 'qrquestion'">
          <QRreader
            :questionId="questions[currentQuestion].id"
            :currentQuestion="currentQuestion"
            :questionText="questions[currentQuestion].questionText"
            :questionMedias="questions[currentQuestion].questionMedias"
            :multiple_correct_answers="
              questions[currentQuestion].multiple_correct_answers
            "
            :answerOptions="questions[currentQuestion].answerOptions"
            @handleAnswerClick="handleAnswerClick"
          />
        </div>
        <div
          v-else-if="
            questions[currentQuestion].questionType === 'imagequestion'
          "
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
                questions[currentQuestion].questionMedias[2].filter ==
                'pixelise'
              "
              :difficulty="questions[currentQuestion].difficulty"
              :local="questions[currentQuestion].local"
            />
            <Flash
              :imgUrl="`${questions[currentQuestion].questionMedias[2].src}`"
              v-else-if="
                questions[currentQuestion].questionMedias[2].filter == 'flash'
              "
              :local="questions[currentQuestion].local"
            />

            <b-img
                 v-else-if="!questions[currentQuestion].local"
              :src="
                require(`./assets/${questions[currentQuestion].questionMedias[2].src}`)
              "
              alt="Image"
              fluid
              thumbnail
              id="img"
            ></b-img>
            <b-img
              v-else
              :src="questions[currentQuestion].questionMedias[2].src"
              alt="Image"
              fluid
              thumbnail
              id="img"
            ></b-img>
            <div id="videoContainer" class="box"></div>
            <b-card-text>
            {{ questions[currentQuestion].questionText}}
            </b-card-text>
            <br />
            <b-progress
              variant="warning"
              :max="30"
              :value="countDown"
              height="4px"
            ></b-progress>

            <b-card-text>
              <span style="font-size: 40px"
                ><strong>{{ countDown }} </strong></span
              >
            </b-card-text>
            <b-card-text>
              {{ questions[currentQuestion].questionText }}
            </b-card-text>
            <div class="answer-section">
              <b-button
                :key="index"
                v-for="(option, index) in questions[currentQuestion]
                  .answerOptions"
                  :disabled="playerAnswear"
                @click="handleAnswerClick(option)"
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
              :value="countDown"
              height="4px"
            ></b-progress>

            <b-card-text>
              <span style="font-size: 40px"
                ><strong>{{ countDown }} </strong></span
              >
            </b-card-text>

            <b-card-text>
              {{ questions[currentQuestion].questionText }}
            </b-card-text>
            <div class="answer-section">
              <b-button
                :key="index"
                v-for="(option, index) in questions[currentQuestion]
                  .answerOptions"
                @click="handleAnswerClick(option)"
                class="ans-option-btn"
                variant="primary"
                :disabled="playerAnswear"
                >{{ option.answerText }}</b-button
              >
            </div>
          </b-card>
        </div>
      </b-col>
      <span> </span>
      <span> </span>
      <b-col
        ><strong>{{ competitor.name }}</strong>

        <h6
          :key="index"
          v-for="(option, index) in competitorAnswear"
        :class="option.color"
          >{{ option.text }}</h6
        >
      </b-col>
    </b-row>
  </div>
  <div v-else>
    waiting for a competitor
    <b-spinner label="Loading..."></b-spinner>
  </div>
</template>



<script>
import Pixel from "./Pixel.vue";
import $ from "jquery";
import Flash from "./Flashlight.vue";
import Form from "./Form.vue";
import QRreader from "./QRreader.vue";
import VideoPlayer from "./component/VideoPlayer.vue";

export default {
  props: {
    questions: { type: Array, required: true },
    userName: {
      type: String,
      required: true,
    },
  },
  components: {
    Pixel,
    Flash,
    QRreader,
  },
  data() {
    return {
      currentQuestion: 0,
      showScore: false,
      myid: "",
      score: 0,
      competitor: {},
      competitorAnswear: [],
      myAnswear: [],
      countDown: 30,
      timer: null,
      playerAnswear:false,
      matchstarted: false,
      socket: null,
      videoOptions: {
        autoplay: true,
        controls: true,
        sources: [
          {
            src: "../assets/Un Chien Andalou .mp4",
            type: "video/mp4",
          },
        ],
      },
    };
  },
  beforeMount: function () {
    this.socket = new WebSocket("ws://localhost:8080/");
  },
  mounted: function () {
    // `this` est une référence à l'instance de vm

    this.socket.onmessage = this.handleMessage;
    localStorage.clear();
    console.log("socket", this.socket);
      console.log("question", this.questions);
  },
  methods: {
    startQuizFunc() {
      this.matchstarted = true;
    },
    handleAnswerClick(answer) {
      // Define the

      console.log("method click called")
      let answearObj = { command: "answear", data: answer.answerText };
      this.socket.send(JSON.stringify(answearObj));

      if (answer.isCorrect)
        this.myAnswear.push({ text: answer.answerText, color: "text-success" });
      else this.myAnswear.push({ text: answer.answerText, color: "text-danger" });
    },
    countDownTimer() {
      if (this.countDown > 0) {
        this.timer = setTimeout(() => {
          this.countDown -= 1;
          this.countDownTimer();
        }, 1000);
      } else {
     "";
      }
    },
    addQuestionFunc() {
      this.addQuestion = true;
    },
    handleMessage: function (e) {
      let message = JSON.parse(e.data);
      let u = this.userName;

      if (message.command == "id") {
        this.myid = message.data;
        let user = { command: "register", data: { name: u, country: "" } };
        this.socket.send(JSON.stringify(user));
      } else if (message.command == "competitorfound") {
        console.log(message);
        this.competitor = message.data;
        this.matchstarted = true;
      } else if (message.command == "competitoranswear") {
        console.log(message.data);
        this.questions[this.currentQuestion].answerOptions.forEach((answer) => {
     
          if (message.data == answer.answerText) {
                 console.log(answer);
            if (answer.isCorrect)
              this.competitorAnswear.push({
                text: answer.answerText,
                color: "text-success",
              });
            else
              this.competitorAnswear.push({ text: answer.answerText, color: "text-danger" });
          }
        });
      }
    },
    created() {
      //  alert(this.$store.state.questionAttended)
      //    this.showScore = localStorage.getItem('testComplete') || false
      //    this.currentQuestion = localStorage.getItem('qattended') || 0
      //    this.countDownTimer()
      //    this.fetchQuiz()
    },
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
