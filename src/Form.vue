<template>
  <b-card title="Add a question" style="max-width: 20rem" class="mb-2">
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-form-group
        id="input-group-1"
        label="Question:"
        label-for="input-1"
        label-align="left"
      >
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
        label-align="left"
      >
        <b-form-file
          id="file"
          name="file"
          multiple
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
          @change="previewFiles"
        ></b-form-file
      ></b-form-group>
      <b-form-group
        id="input-group-3"
        label="Type of question :"
        label-for="input-3"
        label-align="left"
      >
        <b-form-select
          id="input-3"
          v-model="form.questionType"
          :options="questionType"
          required
        ></b-form-select>
      </b-form-group>

      <b-form-group
        id="input-group-3"
        label="Filter:"
        label-for="input-3"
        label-align="left"
        v-if="form.questionType == 'imagequestion'"
      >
        <b-form-select
          id="input-3"
          v-model="selectedfilter"
          :options="filters"
          required
          @change="setFilter"
        ></b-form-select>
      </b-form-group>

      <b-form-group
        label="Multiply-answear"
        label-align="left"
        v-slot="{ ariaDescribedby }"
      >
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
          <b-form-input v-model="answer.answerText" />
          <b-form-radio-group
            label="Radios using sub-components"
            v-slot="{ index }"
            label-align="left"
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
      <br />
      <br />
      <br />

      <b-form-group
        id="input-group-3"
        label="Category:"
        label-for="input-3"
        label-align="left"
      >
        <b-form-select
          id="input-3"
          v-model="form.category"
          :options="categories"
          required
        ></b-form-select>
      </b-form-group>
      <b-form-radio-group label="Difficulty" label-align="left">
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
      <br />
      <b-button-group>
        <b-button @click="saveFile" variant="primary">Submit</b-button>
        <b-button @click="back" variant="info">Back</b-button>
      </b-button-group>
    </b-form>
    <b-card class="mt-3" header="Form Data Result">
      <pre class="m-0">{{ form }}</pre>
    </b-card>
  </b-card>
</template>

<script>
import $ from "jquery";
import UploadService from "./services/UploadFilesService";
export default {
  props: {
    questions: { type: Array, required: true },
  },
  data() {
    return {
      file: null,
      selectedfilter: null,
      form: {
        id: this.questions.length + 1,
        questionText: "",
        multiple_correct_answers: [],
        questionType: "",
        questionMedias: [
          {
            type: "video",
            src: "",
            in: "",
            out: "",
          },
          {
            type: "audio",
            src: "",
          },
          {
            type: "image",
            src: "",
            filter: "",
          },
        ],
        answerOptions: [],
        category: "",
        difficulty: "",
      },
      filters: [{ text: "Select One", value: null }, "pixelise", "flash"],
      categories: [{ text: "Select One", value: null }, "painting", "history"],
      questionType: [
        { text: "Select One", value: null },
        "qrquestion",
        "imagequestion",
        "videoquestion",
      ],
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
    setFilter: function () {
      this.form.questionMedias.forEach((element) => {
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
    // Upload file
    uploadFile() {
      var fd = new FormData();
      var files = $("#file")[0].files;

      // Check file selected or not
      if (files.length > 0) {
        fd.append("file", files[0]);

        $.ajax({
          url: "http://testdeveloppement.site/easyart/uploadfile.php",
          type: "post",
          data: fd,
          contentType: false,
          processData: false,
          success: function (response) {
            if (response != 0) {
              alert("file  uploaded");
            } else {
              alert("file not uploaded");
            }
          },
        });
      } else {
        alert("Please select a file.");
      }
    },
    previewFiles(event) {
      let temp_files = [];

      this.file = event.target.files;
      event.target.files.forEach((element) => {
        let temp_file = {};

        if (element.type.includes("image")) {
            this.form.questionMedias[2].type = "image";
        this.form.questionMedias[2].filter = this.selectedfilter;
          this.form.questionMedias[2].src =
            "http://testdeveloppement.site/easyart/files/" + element.name;
        }

      });

    
      console.log(event.target.files);
    },
    back: function () {
      this.$emit("back");
    },
    saveFile: function () {
      this.form.local = -1;
      this.uploadFile();
      this.$emit("pushQuestion", this.form);
      this.back();
    },
  },
};
</script>