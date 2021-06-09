<template>
  <b-card title="Simple Quiz Application" style="max-width: 20rem" class="mb-2">
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-form-group id="input-group-1" label="Question:" label-for="input-1">
        <b-form-input
          id="input-1"
          v-model="form.questionText"
          placeholder="Enter question"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        id="input-group-1"
        label="Drop question media here:"
        label-for="input-1"
      >
        <b-form-file
          multiple
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
          @change="previewFiles"
        ></b-form-file
      ></b-form-group>

      <b-form-group id="input-group-3" label="Filter:" label-for="input-3">
        <b-form-select
          id="input-3"
          v-model="selectedfilter"
          :options="filters"
          required
            @change="setFilter"
        ></b-form-select>
      </b-form-group>

      <b-form-group label="Multiply-answear" v-slot="{ ariaDescribedby }">
        <b-form-radio
          v-model="form.multiple_correct_answers"
          :aria-describedby="ariaDescribedby"
          name="yes"
          value="true"
          >Yes</b-form-radio
        >
        <b-form-radio
          v-model="form.multiple_correct_answers"
          :aria-describedby="ariaDescribedby"
          name="no"
          value="false"
          >No</b-form-radio
        >
      </b-form-group>

      <div v-for="(answer, index) in form.answerOptions" :key="index">
        <b-form-group>
          <b-form-input v-model="answer.value" />
          <b-form-radio-group
            label="Radios using sub-components"
            v-slot="{ index }"
         
          >
            <b-form-radio
              v-model="answer.isCorrect"
              :aria-describedby="index"
            name="correct"
              value="true"
              >correct</b-form-radio
            >
            <b-form-radio
              v-model="answer.isCorrect"
              :aria-describedby="index"
              name="incorrect"
              value="false"
              >incorrect</b-form-radio
            >
          </b-form-radio-group>
        </b-form-group>
      </div>
      <b-button @click="addAnswear">Add answear</b-button>
      <br>
         <br>
            <br>

  <b-form-group id="input-group-3" label="Category:" label-for="input-3">
        <b-form-select
          id="input-3"
          v-model="form.category"
          :options="categories"
          required
        ></b-form-select>
      </b-form-group>
       <b-form-radio-group
            label="Difficulty"
          >
            <b-form-radio
              v-model="form.difficulty"
              :aria-describedby="index"
            name="easy"
              value="easy"
              >easy</b-form-radio
            >
            <b-form-radio
              v-model="form.difficulty"
              :aria-describedby="index"
              name="medium"
              value="medium"
              >medium</b-form-radio
            >
                  <b-form-radio
              v-model="form.difficulty"
              :aria-describedby="index"
              name="hard"
              value="hard"
              >hard</b-form-radio
            >
          </b-form-radio-group>


      <b-button type="submit" variant="primary">Submit</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
      <b-button  @click="back" variant="info">Back</b-button>
    </b-form>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ form }}</pre>
    </b-card>
  </b-card>
</template>

<script>
export default {
  data() {
    return {
      file: null,
      selectedfilter: null,
      form: {
        questionText: "",
        multiple_correct_answers: [],
        questionMedias: [
          {
            type: "",
            src: "",
            filter: this.selectedfilter,
          },
        ],
        answerOptions: [],
        category:"",
           difficulty:"",
      },
      filters: [{ text: "Select One", value: null }, "Pixels", "Flash"],
        categories: [{ text: "Select One", value: null }, "painting", "history"],
      show: true,
    };
  },

  /*


questions : [
    {
        questionText: 'Who painted this picture?',          
        questionMedias: [
        {
        type:"video",
        src:"/video.mp4",
        in:55,
        out:90,
        },
        {
        type:"audio",
        src:"/sound.mp3",            
        },
        {
        type:"image",
        src:"Gustav_Klimt.jpg",
        filter:"pixelise",              
        }
    ],
    multiple_correct_answers: "false",
    answerOptions: [
        { 
        answerText: 'Salvador Dali',
        answerImage: 'dali.jpg',
        isCorrect: false,
        },
        { answerText: 'Gustav Klimt', isCorrect: true },
        { answerText: 'Paul Klee', isCorrect: false },
        { answerText: 'Jackson Pollock', isCorrect: false },                            
    ],
    category: "painting",
    difficulty: "easy"
}



  */
  methods: {
    onSubmit(event) {
      event.preventDefault();
      alert(JSON.stringify(this.form));
    },
    addAnswear: function () {
      this.form.answerOptions.push({ value: "" });
    },
    back: function () {
    
    },
    setFilter: function () {
     this.form.questionMedias.forEach(element => {
        if (element.type.includes("image")) {
      
          element.filter = this.selectedfilter;

        }
    });
    },
    onReset(event) {
      event.preventDefault();
      // Reset our form values
      this.form.email = "";
      this.form.name = "";
      this.form.filters = null;
      this.form.multiple_correct_answers = [];
      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });
    },
    previewFiles(event) {
      let temp_files = [];
      event.target.files.forEach((element) => {
        let temp_file = {};

        if (element.type.includes("image")) {
          temp_file.type = "image";
          temp_file.filter = this.selectedfilter;
          temp_file.src = element.name;
        }
        temp_files.push(temp_file);
      });

      this.form.questionMedias = temp_files;
      console.log(event.target.files);
    },
      saveFile: function() {
       
  }
  },
};
</script>