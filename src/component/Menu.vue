<template>
  <div class="text-center maindiv d-flex justify-content-center">
   
    <Quizz v-if="startQuiz"  @pushScored="pushScored"/>

    <div class="card-q"  v-else-if="addQuestion">
      <Form/>
    </div>
    <div class="card-q"  v-else>
      <b-card>
        <b-card-text>
          <h1>Bienvenu {{ userName }}</h1>
        </b-card-text>
        <b-list-group>
            Last Scored
          <b-list-group-item  
          :key="index"
          v-for="(option, index) in scored">
          
         {{ option }} </b-list-group-item>

        </b-list-group>
        <br>
        <b-container class="bv-example-row">
          <b-row>
            <b-col>  <b-button variant="outline-primary" @click="addQuestionClick()">Add Question</b-button></b-col>
            <b-col>  <b-button variant="outline-primary" @click="startQuizClick()">Start the Quiz</b-button></b-col>
  
          </b-row>
        </b-container>
      </b-card>
    </div>
  </div>
</template>

<script>
import Quizz from "../Quiz";
import Form from "../Form";
export default {
    components: {
   Quizz,Form
  },
  props: {
    userName: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
    startQuiz:false,
     addQuestion:false,
  scored:[]

    };
  },
   created: function () {
    // `this` est une référence à l'instance de vm
    let dback=JSON.parse(window.localStorage.getItem('score'))
    console.log(dback)
    if(dback!=null&&dback!="undefined")
    this.scored=dback
   ;
  },
   methods: {
    startQuizClick() {
      this.startQuiz = true;
    
    },
        addQuestionClick() {
      this.addQuestion = true;
    
    },
    pushScored(score)
    {
this.scored.push(this.userName+" : "+score);
this.saveScore();
 this.startQuiz = false;
 console.log("end")
 
    },
     saveScore() {
        const data = JSON.stringify(this.scored)
        window.localStorage.setItem('score', data);


        console.log(JSON.parse(window.localStorage.getItem('score')))
  }
   }
};
</script>
    <style scoped>
    .span{  min-width: 100%;
  border-radius: 15px;
  padding: 20px;
  box-shadow: 10px 10px 42px 0px rgba(0, 0, 0, 0.75);}
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