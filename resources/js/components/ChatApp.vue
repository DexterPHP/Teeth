<template>

    <div class="chat-app ">

        <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
        <ContactList :contacts="contacts" @selected="startConversationWith"/>
    </div>

</template>

<script>

     import Conversation from './Conversation';
     import ContactList from './ContactList';

     export default {
         props :{
           user: {
               type: Object,
               required: true,
           }
         },
         data:()=> {
         return  {
             selectedContact : null,
             messages : [],
             contacts: []
             };
         },

         methods: {
             startConversationWith(contact){
                 axios.get(`/messenger/Conversation/${contact.id}`).then(
                     (responce)=>{
                         this.messages = responce.data;
                         this.selectedContact = contact;
                     }
                 );
             },
             saveNewMessage(text){
                 this.messages.push(text);
             },
             handleIncoming(message){
                 if(this.selectedContact && message.from_user == this.selectedContact.id){
                     this.saveNewMessage(message);
                     return;
                 }
                 var audio = new Audio('sound/notify.mp3');
                 audio.play();
                 alert('هنالك رسالة جديدة');
             }
         },
         mounted:function () {
             var vm = this;
             Echo.private(`messages.${this.user.id}`)
                 .listen('NewMessage', (e,vm) => {
                     this.handleIncoming(e.message);
                 });
             axios.get('/messenger/contacts')
                 .then((response) => {
                     this.contacts = response.data;
                 });
         },
         components: {Conversation,ContactList}
     }
</script>

<style lang="scss" scoped>
    .chat-app {
        display: flex;
        height: 500px;
    }
</style>
