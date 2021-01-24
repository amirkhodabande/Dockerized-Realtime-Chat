<template>
      <div class=" m-auto col-sm-10 col-md-5 ">
            <li class="list-group-item active pt-4  rounded-top d-flex flex-wrap justify-content-between">
                  <p>Chatroom
                        <small
                              v-if="typing == true"
                              class="badge badge-info text-white"
                        ><i>Typing...</i></small>
                  </p>
                  <p class="badg badge-pill badge-light text-primary border border-info">{{ numberOfUsers }}</p>
            </li>
            <ul
                  class="list-group"
                  v-chat-scroll
            >
                  <message
                        v-for="data in chat.messages"
                        :key="data.index"
                  >
                        <template #message>{{ data.message }}</template>
                        <template #user>{{ data.user_id }}</template>
                        <template #time>{{ data.time }}</template>
                        <template
                              #color
                              v-if="data.user_id == 'You'"
                        >success</template>
                        <template
                              #color
                              v-else
                        >warning</template>
                  </message>
            </ul>
            <input
                  type="text"
                  @keyup.enter="send"
                  v-model="message"
                  class="list-group-item form-control rounded-0"
                  placeholder="Type your message here..."
            >
      </div>
</template>

<script>
import Vue from "vue";

// Auto Scrolling
import VueChatScroll from "vue-chat-scroll";
Vue.use(VueChatScroll);
// Notifications
import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

import Message from "./children/Message.vue";
export default {
      components: {
            message: require("./children/Message.vue").default,
      },
      mounted() {
            this.getMessages();
            this.listen();
      },
      data() {
            return {
                  message: "",
                  chat: {
                        messages: [],
                  },
                  typing: false,
                  numberOfUsers: 0,
            };
      },
      watch: {
            message() {
                  Echo.private("chat").whisper("typing", {
                        name: this.message,
                  });
            },
      },
      methods: {
            listen() {
                  Echo.private("chat")
                        .listen("NewMessage", (response) => {
                              this.chat.messages.push(response);
                        })
                        .listenForWhisper("typing", (e) => {
                              if (e.name != "") {
                                    this.typing = true;
                              } else {
                                    this.typing = false;
                              }
                        });
                  Echo.join("chat")
                        .here((users) => {
                              this.numberOfUsers = users.length;
                        })
                        .joining((user) => {
                              this.numberOfUsers += 1;
                              this.$toaster.success(
                                    `${user.name} Joined to this room.`
                              );
                        })
                        .leaving((user) => {
                              this.numberOfUsers -= 1;
                              this.$toaster.warning(
                                    `${user.name} Leaved this room.`
                              );
                        });
            },
            getMessages() {
                  axios.get(`/api/chat`)
                        .then((response) => {
                              this.chat.messages = response.data;
                        })
                        .catch(function (error) {
                              console.log(
                                    "Error, we cant load messages! Please refresh your page."
                              );
                        });
            },
            send() {
                  if (this.message.length > 0) {
                        axios.post(`/chat`, {
                              message: this.message,
                              time: this.getTime(),
                        })
                              .then((response) => {
                                    this.chat.messages.push({
                                          message: this.message,
                                          user_id: "You",
                                          time: this.getTime(),
                                    });
                                    this.message = "";
                              })
                              .catch((error) => {
                                    console.log("Error, please try later.");
                              });
                  }
            },
            getTime() {
                  let time = new Date();
                  return time.getHours() + ":" + time.getMinutes();
            },
      },
};
</script>

<style>
.list-group {
      overflow-y: scroll;
      height: 250px;
      background-color: rgba(243, 220, 184, 0.24);
}
</style>
