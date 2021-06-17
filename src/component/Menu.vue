<template>
  <div class="text-center maindiv d-flex justify-content-center">
    <Quizz v-if="startQuiz" @pushScored="pushScored" :questions="questions" />

    <div class="card-q" v-else-if="addQuestion">
      <Form :questions="questions" @back="back"    @pushQuestion="pushQuestion"/>
    </div>
    <div class="card-q" v-else-if="scanQuestion">
      <ScanQRquestion
        @back="back"
        :questions="questions"
        @pushQuestion="pushQuestion"
        @setscanQuestion="setscanQuestion"
      />
    </div>
    <div class="card-q" v-else-if="startMatch">
      <Match
        @pushScored="pushScored" :questions="questions" :userName="userName"
      />
    </div>
    <div class="card-q" v-else>
      <b-card>
        <b-card-text>
          <h1>Bienvenu {{ userName }}</h1>
        </b-card-text>
        <b-list-group>
          Last Scores
          <b-list-group-item :key="index" v-for="(option, index) in scored">
            <b-img
              :src="`https://www.countryflags.io/${option.country}/flat/64.png`"
            ></b-img>
            {{ option.date + " - " + option.username + " : " + option.score }}
          </b-list-group-item>
        </b-list-group>
        <br />
        <b-container class="bv-example-row">
          <b-row>
            <b-col>
              <b-button variant="outline-primary" @click="addQuestionClick()"
                >Add Question</b-button
              ></b-col
            >
            <b-col>
              <b-button variant="outline-primary" @click="scanQuestionClick()"
                >Scan Question</b-button
              ></b-col
            >
            <b-col>
              <b-button variant="outline-primary" @click="startQuizClick()"
                >Start the Quiz</b-button
              ></b-col
            >
              <b-col>
              <b-button variant="outline-primary" @click="startMatchClick()"
                >Match</b-button
              ></b-col
            >
          </b-row>
        </b-container>
      </b-card>
    </div>
  </div>
</template>

<script>
import Quizz from "../Quiz";
import Form from "../Form";
import Match from "../Match";
import ScanQRquestion from "../scanQRquestion";
const axios = require("axios").default;
import $ from "jquery";
export default {
  components: {
    Quizz,
    Form,
    ScanQRquestion,
    Match
  },
  props: {
    userName: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      startQuiz: false,
      addQuestion: false,
            startMatch: false,
      scanQuestion: false,
      scored: [],
      questions: [
        {
          id: "0",
          category: "painting",
          difficulty: "easy",
          questionType: "imagequestion",
          questionText: "Who painted this ?",
          multiple_correct_answers: "",
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
              src: "DaVinci.jpg",
              filter: "",
            },
          ],
          answerOptions: [
            {
              answerText: "Salvador Dali",
              isCorrect: false,
            },
            { answerText: "Da Vinci", isCorrect: true },
            { answerText: "Paul Klee", isCorrect: false },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
        },
        {
          id: "1",
          category: "painting",
          difficulty: "easy",
          questionType: "imagequestion",
          questionText: "Who painted this ?",
          multiple_correct_answers: "",
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
          answerOptions: [
            {
              answerText: "Salvador Dali",
              isCorrect: false,
            },
            { answerText: "Gustav Klimt", isCorrect: true },
            { answerText: "Paul Klee", isCorrect: false },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
        },
        {
          id: "2",
          category: "painting",
          difficulty: "easy",
          questionType: "imagequestion",
          questionText: "",
          multiple_correct_answers: "",
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
          answerOptions: [
            {
              answerText: "Salvador Dali",
              isCorrect: false,
            },
            { answerText: "Gustav Klimt", isCorrect: false },
            { answerText: "Paul Klee", isCorrect: true },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
        },
        {
          id: "3",
          category: "painting",
          difficulty: "easy",
          questionType: "qrquestion",
          questionText: "Find a painting of Dali",
          multiple_correct_answers: "",
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
          answerOptions: [
            {
              answerText: "Salvador Dali",
              isCorrect: true,
            },
            { answerText: "Gustav Klimt", isCorrect: false },
            { answerText: "Paul Klee", isCorrect: false },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
        },
        {
          id: "4",
          category: "painting",
          difficulty: "easy",
          questionType: "videoquestion",
          questionText: "",
          multiple_correct_answers: "",
          questionMedias: [
            {
              type: "video",
              src: "Un Chien Andalou .mp4",
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
          answerOptions: [
            {
              answerText: "Salvador Dali",
              isCorrect: true,
            },
            { answerText: "Gustav Klimt", isCorrect: false },
            { answerText: "Paul Klee", isCorrect: false },
            { answerText: "Jackson Pollock", isCorrect: false },
          ],
        },
      ],
    };
  },
  created: function () {
    // `this` est une référence à l'instance de vm

    axios
      .get("http://testdeveloppement.site/easyart/getscore.php")
      .then((response) => {
        console.log(response);
        this.scored = response.data.sort((a,b) => (parseInt(a.score) < parseInt(b.score) ? 1 :  -1));
      });
  },
  methods: {
    startQuizClick() {
      this.startQuiz = true;
    },
    startMatchClick() {
      this.startMatch = true;
    },
    addQuestionClick() {
      this.addQuestion = true;
    },
    scanQuestionClick() {
      this.scanQuestion = true;
    },
    pushScored(score) {
      this.saveScore(score);
      this.startQuiz = false;
      console.log("end");
    },
    setscanQuestion() {
      this.scanQuestion = false;
    },
    saveScore(score) {
      /*axios
        .post(
          "http://testdeveloppement.site/easyart/insertscore.php",
          {
            username: this.userName,
            score: score,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "*",
              "Access-Control-Allow-Methods":
                "GET, POST, PATCH, PUT, DELETE, OPTIONS",
              "Access-Control-Allow-Headers":
                "Origin, Content-Type, X-Auth-Token",
            },
          }
        )
        .then(function (response) {
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });*/
      axios.get("https://api.ipify.org?format=json").then((response) => {
        let ip = response.data.ip;
        axios.get("https://ipapi.co/" + ip + "/country/").then((response) => {
          console.log(response.data);
          this.scored.push({
            username: this.userName,
            score: score,
            date: this.currentDate(),
            country:response.data
          });
             this.scored = this.scored.sort((a,b) => (parseInt(a.score) < parseInt(b.score) ? 1 :  -1));
          $.post(
            "http://testdeveloppement.site/easyart/insertscore.php",
            {
              username: this.userName,
              score: score,
              ip: ip,
              country: response.data,
            },
            function (data) {}
          );
        });
      });
    },
    currentDate() {
      const current = new Date();
      const date = `${current.getDate()}/${
        current.getMonth() + 1
      }/${current.getFullYear()}`;
      return date;
    },
    pushQuestion(question) {
      this.questions.push(question);
    },
    back() {
      this.startQuiz = false;
      this.addQuestion = false;
      this.scanQuestion = false;
    },
  },
};
</script>
    <style scoped>
.span {
  min-width: 100%;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 10px 10px 42px 0px rgba(0, 0, 0, 0.75);
}
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