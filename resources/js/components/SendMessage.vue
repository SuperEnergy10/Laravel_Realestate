<template>
  
<div>

   <!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#chat">
  Chat Now
</button>

<!-- Modal -->
<div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Chat With {{ receiverid }} {{ receivername }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="sendMsg()">
    <div class="modal-body">
        <div class="form-group">
            <textarea class="form-control" v-model="form.msg" id="" rows="3" placeholder="Type your message"></textarea>
            <span class="text-success" v-if="successMessage.message">{{ successMessage.message }}</span>
            <span class="text-danger" v-if="errors.msg">{{ errors.msg[0] }}</span>        
        </div>
    </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </div>

    </form>

    </div>
  </div>
</div>
</div>

</template>

<script>
import axios from 'axios';

export default {
  props: ['receiverid', 'receivername'],

  data() {
    return {
      form: {
        msg: "",
        receiver_id: this.receiverid
      },
      errors:{},
      successMessage:{}
    };
  },

  methods: {
    sendMsg() {
         // Reset previous errors before making a new request
      this.errors = {}; 

      axios.post('/send-message', this.form)
      .then((res) => {
        this.form.msg = ""; // xoá msg đã nhập
        this.successMessage = res.data;
        console.log(res.data);

        // Hide success message after 3 seconds
        setTimeout(() => {
            this.successMessage = {};  // Clear success message
          }, 3000);  // 3 seconds

      }).catch((err) => {
      this.errors = err.response.data.errors;
      })
    }
  }
};
</script>
