<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : 'Select a Contact'}}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessagesComposer  @send="SendMassage"/>
    </div>
</template>

<script>
    import MessagesFeed     from './MessagesFeed';
    import MessagesComposer from './MessagesComposer';
    export default {
        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }

        },
        methods: {
            SendMassage(Text) {
                if(!this.contact){
                    return;
                }
                axios.post('/messenger/Conversation/send',{
                    contact_id: this.contact.id,
                    text: Text,
                }).then((responce) => {
                    this.$emit('new',responce.data);

                })
            }
        },
        components: {MessagesFeed,MessagesComposer}

    }
</script>
<style lang="scss" scoped>
    .conversation {
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        h1 {
            font-size: 20px;
            padding: 10px;
            margin: 0;
            border-bottom: 1px dashed lightgray;
        }
    }
</style>
