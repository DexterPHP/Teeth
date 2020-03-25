<template>
    <div class="contacts-list">
        <ul>
            <li v-for="(contact,index) in contacts" :key="contact.id" @click="selectContact(index,contact)"  :class="{ 'selected': contact == selected }">
                <div class="contact">
                    <p class="name">{{contact.name}}</p>
                    <p class="email">{{contact.created_at}}</p>
                </div>
                <div class="avatar">
                    <img class="contacts-list-img" :src="contact.profile_image" :alt="contact.name">
                </div>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        props: {
            contacts: {
                type: Array,
                default: [],
            },
        },
        data : ()=>{
            return {
                selected : 0
            };
        },

        methods: {
            selectContact(index,contact){
                this.selected = index;
                this.$emit('selected',contact);
            },


        }


    }
</script>
<style lang="scss" scoped>
    .contacts-list {
        flex:2;
        max-height:600px;
        text-align: right;
        overflow-y:scroll;
        overflow-x:hidden;
        border-left:1px solid black;
        background-color: #343a40;
        ul{
            list-style-type: none;
            padding-left: 0;
            li {
                display:flex;
                padding: 2px;
                border-bottom: 1px solid #aaaaaa;
                height:88px;
                position:relative;
                cursor:pointer;
                &.selected{
                    background-color: #dfdfdf;
                }
                span.unread {
                    background: #82e0a8;
                    color: #fff;
                    position: absolute;
                    right: 11px;
                    top: 20px;
                    display: flex;
                    font-weight: 700;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 3px;
                }
                .avatar{
                    display: flex;
                    flex: 0.5;
                    align-items: center;
                    img{
                        width: 50px;
                        border-radius: 50%;
                        margin: 0 auto;

                    }
                }
            }
            .contact{
                flex: 2;
                font-size: 12px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;
                color: #fafafa;
                p{
                    margin: 0;
                    &.name{
                        font-weight:bold;
                    }
                }
            }

        }

    }


</style>
