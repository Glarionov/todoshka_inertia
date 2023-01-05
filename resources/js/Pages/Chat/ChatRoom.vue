<script setup>
import {computed, onMounted, ref} from "vue";
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import ChatLayout from "@/Layouts/ChatLayout.vue";
import RequestHelper from "@/Helpers/RequestHelper";

let messages = ref({});
const user = usePage().props.value.auth.user;
let blockLoading = false;
let lastMessageId = null;
let request = new RequestHelper();
let showSidebarOnNarrowScreen = ref(false);

const props = defineProps({
    initialOnlineUsers: {
        default: [],
    },
});

const form = useForm({
    text: '',
});

let onlineUsers = ref(props.initialOnlineUsers ? props.initialOnlineUsers.data : []);

const scrollToBottom = () => {
    setTimeout(() => {
        let topPos = document.getElementById('inner-element').offsetTop;
        document.getElementById('container').scrollTop = topPos - 10;
    }, 1);
}

const loadMessages = async (initialLoad = false) => {
    let url = '/messages';
    if (!initialLoad && lastMessageId) {
        url += '?message_id=' + lastMessageId;
    }
    let response = await request.get(url, "Can't load messages");

    if (response.error) {
        return false;
    }

    messages.value = {...response.data.data, ...messages.value};
    lastMessageId = Object.keys(messages.value)[0];
    if (initialLoad) {
        scrollToBottom();
    }

    if (response.data.data) {
        setTimeout(() => {
            blockLoading = false
        }, 500);
    }
}

const sendMessage = async () => {
    form.post(route('messages.store'));
    form.text = '';
}

const handleScroll = async () => {
    let scrollValue = document.getElementById('container').scrollTop;

    if (scrollValue < 200 && !blockLoading) {
        blockLoading = true;
        loadMessages(false);
    }
}

const listenUpdates = async () => {
    window.Echo.channel('messages')
        .listen('MessageSent', callbackData => {
            if (callbackData.message) {
                callbackData.message.own = callbackData.message.user_id === user.id;
                messages.value[callbackData.message.id] = callbackData.message;

                if (callbackData.message.own) {
                    scrollToBottom();
                }
            }
        });

    window.Echo.channel('users')
        .listen('OnlineUsersUpdateNeeded', callbackData => {
            if (callbackData.onlineUsers) {
                onlineUsers.value = callbackData.onlineUsers;
            }
        });
}

const formError = computed(() => {
    if (form.errors.text) {
        return form.errors.text;
    }

    const checkRegex = /^[A-z]*$/;

    // Ниже примерная регулярка, которая проверяла бы "более реальные требования к тексту"
    // const checkRegex = /^[A-z|\s|\d|А-я|\.]*$/;
    if (!form.text || form.text.match(checkRegex)) {
        return '';
    }
    return 'The text must only contain letters.';
});

const clearErrors = () => {
    form.clearErrors();
}

onMounted(() => {
    listenUpdates();
    loadMessages(true);
});

</script>

<template>
    <ChatLayout>
        <template #extra-header-elements>
            <div class="py-2 pl-3 pr-4 hover:bg-white hover:text-gray-400 cursor-pointer xl:hidden"
                 @click="showSidebarOnNarrowScreen = !showSidebarOnNarrowScreen">
                <span v-if="showSidebarOnNarrowScreen">Hide</span>
                <span v-else>Show</span> online users
            </div>
        </template>
        <template #default>
            <div class="p-4 w-60 absolute bg-gray-700 m-4 xl:inline-block"
                 :class="{'hidden': !showSidebarOnNarrowScreen}">
                <div class="text-white">Users online:</div>
                <div v-for="(onlineUser, index) in onlineUsers" :key="index" class="text-yellow-300 mt-3">
                    {{ onlineUser.name }}
                </div>
            </div>
            <div class="max-w-screen-md w-full m-auto">
                <div class="messages bg-gray-800 overflow-y-auto" id="container" @scroll="handleScroll">
                    <div v-for="(message) in messages" :key="message.id" class="chat-message">
                        <div class="p-2 messages__box">
                            <div class="chat-message">
                                <div class="flex items-end" :class="{'justify-end': message.own}">
                                    <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 items-end"
                                         :class="[message.own? 'order-1': 'order-2']">
                                        <div>
                                            <div class="px-4 py-2 rounded-lg inline-block break-all"
                                                 :class="[message.own? 'bg-blue-600': 'bg-green-800']">
                                                <div class="text-yellow-400">
                                                    {{ message.user_name }}
                                                </div>
                                                <div class="text-white whitespace-pre">
                                                    {{ message.text }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <img
                                        src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144"
                                        alt="My profile" class="w-6 h-6 rounded-full"
                                        :class="[message.own? 'order-2': 'order-1']">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="inner-element"></div>
                </div>

                <form class="max-w-screen-md m-auto bg-gray-900 send-message-form m-auto" @submit.prevent="sendMessage">
                    <div class="flex items-center h-full p-2 pt-4">
                    <textarea
                        class="appearance-none w-full text-gray-700 mr-3 bg-gray-700
                         py-1 px-2 leading-tight focus:outline-none h-full resize-none text-white"
                        v-model="form.text"
                        @keyup.enter.exact="sendMessage"
                        @input="clearErrors"
                        placeholder="Type new message here"/>
                        <button type="submit"
                                class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500
                                hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded">
                            Send
                        </button>
                    </div>
                </form>
                <div class="text-red-400 w-full bg-gray-900 error-box p-2">{{ formError }}</div>
            </div>
        </template>
    </ChatLayout>

</template>

<style scoped>
.messages {
    height: calc(100vh - 174px);
}

.send-message-form {
    height: 80px;
}

.error-box {
    min-height: 40px;
}
</style>
