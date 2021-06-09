<template>
  <div class="d-flex justify-content-center">
    <div v-if="showScore">
      <b-card title="Results" style="max-width: 20rem">
        You Scored {{ score }} of {{ questions.length }}
      </b-card>
    </div>
    <div class="card-q" v-else>
      <span v-if="!startQuiz && !addQuestion">
        <b-card
          title="Simple Quiz Application"
          style="max-width: 20rem"
          class="mb-2"
        >
          <b-img
            src="https://www.artst.org/wp-content/uploads/2020/06/Famous-Paintings.jpg"
            alt="Image"
            fluid
            id="img"
          ></b-img>

          <b-card-text>
            Based on the work of Arpan Adhikari:
            <a
              target="_blank"
              href="https://github.com/arpan45/simple-quiz-vue"
            >
              Github Repo
            </a>
          </b-card-text>
          <b-button @click="startQuizFunc()">Start Quiz</b-button>
          <br />
          <b-button @click="addQuestionFunc()">Add a question</b-button>
        </b-card>
      </span>
      <span v-else-if="questions[currentQuestion].qrquestion">
        <QRreader
        :currentQuestion="currentQuestion"
          :questionText="questions[currentQuestion].questionText"
          :questionMedias="questions[currentQuestion].questionMedias"
          :multiple_correct_answers="
            questions[currentQuestion].multiple_correct_answers
          "
          :answerOptions="questions[currentQuestion].answerOptions"
        />
      </span>
      <span v-else-if="!addQuestion">
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
              @click="handleAnswerClick(option.isCorrect)"
              class="ans-option-btn"
              variant="primary"
              >{{ option.answerText }}</b-button
            >
          </div>
        </b-card>
      </span>
      <span v-if="addQuestion">
        <Form />
      </span>
    </div>
  </div>
</template>

<script>
import Pixel from "./Pixel.vue";
import $ from "jquery";
import Flash from "./Flashlight.vue";
import Form from "./Form.vue";
import QRreader from "./QRreader.vue";
export default {
  components: {
    Pixel,
    Flash,
    Form,
    QRreader,
  },
  data() {
    return {
      currentQuestion: 0,
      showScore: false,
      score: 0,
      countDown: 30,
      timer: null,
      startQuiz: false,
      addQuestion: false,
      img1: null,
      questions: [
        {
          id:"1",
          questionText: "Who painted this picture?",
          questionMedias: [
            {
              type: "video",
              src: "/video.mp4",
              in: 55,
              out: 90,
            },
            {
              type: "audio",
              src: "/sound.mp3",
            },
            {
              type: "image",
              src: "Gustav_Klimt.jpg",
              filter: "flash",
            },
          ],
          multiple_correct_answers: "false",
          qrquestion: true,
          answerOptions: [
            {
              answerText: "Salvador Dali",
              answerImage: "dali.jpg",
              isCorrect: false,
            },
            { answerText: "Gustav Klimt", isCorrect: true },
            { answerText: "Paul Klee", isCorrect: false },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
          category: "painting",
          difficulty: "easy",
        },
        {
           id:"2",
          questionText: "Who painted this picture?",
          questionMedias: [
            {
              type: "video",
              src: "/video.mp4",
              in: 55,
              out: 90,
            },
            {
              type: "audio",
              src: "/sound.mp3",
            },
            {
              type: "image",
              src: "Paul_Klee.jpg",
              filter: "pixelise",
            },
          ],
          multiple_correct_answers: "false",
          qrquestion: false,
          answerOptions: [
            {
              answerText: "Salvador Dali",
              answerImage: "dali.jpg",
              isCorrect: false,
            },
            { answerText: "Gustav Klimt", isCorrect: false },
            { answerText: "Paul Klee", isCorrect: true },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
          category: "painting",
          difficulty: "easy",
        },
        {
          questionText: "Who painted this picture?",
          questionMedias: [
            {
              type: "video",
              src: "/video.mp4",
              in: 55,
              out: 90,
            },
            {
              type: "audio",
              src: "/sound.mp3",
            },
            {
              type: "image",
              src: "Salvador_Dali.jpg",
              filter: "none",
            },
          ],
          multiple_correct_answers: "false",
          qrquestion: false,
          answerOptions: [
            {
              answerText: "Salvador Dali",
              answerImage: "dali.jpg",
              isCorrect: true,
            },
            { answerText: "Gustav Klimt", isCorrect: false },
            { answerText: "Paul Klee", isCorrect: false },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
          category: "painting",
          difficulty: "easy",
        },
      ],
    };
  },
  methods: {
    startQuizFunc() {
      this.startQuiz = true;
      this.countDownTimer();
    },
    handleAnswerClick(isCorrect) {
      clearTimeout(this.timer);
      let nextQuestion = this.currentQuestion + 1;
      if (isCorrect) {
        this.score = this.score + 1;
      }
      if (nextQuestion < this.questions.length) {
        this.currentQuestion = nextQuestion;
        // this.$store.state.questionAttended = this.currentQuestion;
        // localStorage.setItem('qattended', this.currentQuestion)
        // $("#img").hide();
        this.countDown = 30;
        this.countDownTimer();
      } else {
        // localStorage.removeItem('qattended')
        this.showScore = true;
        // localStorage.setItem('testComplete',this.showScore)
      }
    },
    countDownTimer() {
      if (this.countDown > 0) {
        this.timer = setTimeout(() => {
          this.countDown -= 1;
          this.countDownTimer();
        }, 1000);
      } else {
        this.handleAnswerClick(false);
      }
    },
    addQuestionFunc() {
      this.addQuestion = true;
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
