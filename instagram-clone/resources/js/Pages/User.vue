<script setup>
import { reactive, toRefs } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const message = ref('');
const messageType = ref('');
const messageVisible = ref(false);

import MainLayout from '@/Layouts/MainLayout.vue';
import ShowPostOverlay from '@/Components/ShowPostOverlay.vue'
import ContentOverlay from '@/Components/ContentOverlay.vue'

import Cog from 'vue-material-design-icons/Cog.vue';
import Grid from 'vue-material-design-icons/Grid.vue';
import PlayBoxOutline from 'vue-material-design-icons/PlayBoxOutline.vue';
import BookmarkOutline from 'vue-material-design-icons/BookmarkOutline.vue';
import AccountBoxOutline from 'vue-material-design-icons/AccountBoxOutline.vue';

// let data = reactive({ post: null })
const form = reactive({ file: null })

// const props = defineProps({ postsByUser: Object, user: Object })
// const { postsByUser, user } = toRefs(props)

const props = defineProps({
  postsByUser: Object, 
  user: Object,
  isFollowing: {
        type: Boolean,
        default: false
    },
  followerCount: {
        type: Number,
        default: 0 
    },
    followingCount: {
        type: Number,
        default: 0 
}})

const { postsByUser, user, isFollowing, followerCount, followingCount } = toRefs(props);

let data = reactive({
    post: null,
    followerCount: followerCount.value,
    followingCount: followingCount.value,
    isFollowing: isFollowing.value
});




const addComment = (object) => {
    router.post('/comments', {
        post_id: object.post.id,
        user_id: object.user._id,
        comment: object.comment
    }, {
        onFinish: () => updatedPost(object),
    }
    )
}

const deleteFunc = (object) => {
    let url = ''
    if (object.deleteType === 'Post') {
        url = '/posts/' + object.id
        setTimeout(() => data.post = null, 100)
    } else {
        url = '/comments/' + object.id
    }

    router.delete(url, {
        onFinish: () => updatedPost(object),
    })
}

const updateLike = (object) => {
    let deleteLike = false
    let id = null

    for (let i = 0; i < object.post.likes.length; i++) {
        const like = object.post.likes[i];
        if (like.user_id === object.user._id && like.post_id === object.post.id) {
            deleteLike = true
            id = like.id
        }
    }

    if (deleteLike) {
        router.delete('/likes/' + id, {
            onFinish: () => updatedPost(object),
        })
    } else {
        router.post('/likes', {
            post_id: object.post.id,
        },{
            onFinish: () => updatedPost(object),
        })
    }
}

const updatedPost = (object) => {
    for (let i = 0; i < postsByUser.value.data.length; i++) {
        const post = postsByUser.value.data[i];
        if (post.id === object.post.id) {
            data.post = post
        }
    }
}

const getUploadedImage = (e) => {
    form.file = e.target.files[0]
    router.post(`/users`, form, {
        preserveState: false
    })
}


const followUser = (userId) => {
    router.post(`/user/follow/${userId}`, {}, {
        onSuccess: (response) => {
            // state.isFollowing = true;
            state.followerCount = response.props.followerCount; 
            state.followingCount = response.props.followingCount; 
        }
    });
};

const unfollowUser = (userId) => {
    // state.isFollowing = false;
  router.delete(`/user/unfollow/${userId}`, {
    onSuccess: ({ props }) => {
      
      state.followerCount = props.followerCount; 
    }
  });
};

function showMessage(type, text) {
    messageType.value = type;
    message.value = text;
    messageVisible.value = true;
    setTimeout(() => {
        messageVisible.value = false;
    }, 3000); 
}

</script>


<template>
    <Head title="Instagram" />

    <MainLayout>
        <div class="pt-2 md:pt-6"></div>
        <div class="max-w-[880px] lg:ml-0 md:ml-[80px] md:pl-20 px-4 w-[100vw]">
            <div class="flex items-center md:justify-between">

                <label for="fileUser">
                    <img
                        class="rounded-full object-fit md:w-[200px] w-[100px] cursor-pointer"
                        :src="user.file"
                    >
                </label>
                <input
                    v-if="user._id === $page.props.auth.user._id"
                    id="fileUser"
                    class="hidden"
                    type="file"
                    @input="getUploadedImage($event)"
                >

                <div class="ml-6 w-full">
                    <div class="flex items-center md:mb-8 mb-5">
                        <div class="md:mr-6 mr-3 rounded-lg text-[22px]">{{ user.name }}</div>
                        
                        <Link  v-if="user._id === $page.props.auth.user._id" class="md:block hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-100 hover:bg-gray-200"
                            :href="route('profile.edit', { id: user._id })"
                        >
                            Edit Profile
                        </Link>

                        <div v-if="user._id !== $page.props.auth.user._id">

                            <button @click="followUser(user._id)"
                                    class="md:block hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-100 hover:bg-gray-200">
                                Follow
                            </button>
                            <br>
                            <button @click="unfollowUser(user._id)"
                                    class="md:block hidden md:mr-6 p-1 px-4 rounded-lg text-[16px] font-extrabold bg-gray-100 hover:bg-gray-200">
                                Unfollow
                            </button>
                        </div>
      
                        <!-- <Cog :size="28" class="cursor-pointer"/> -->
                    </div>

                    <button class="md:hidden mr-6 p-1 px-4 max-w-[260px] w-full rounded-lg text-[17px] font-extrabold bg-gray-100 hover:bg-gray-200">
                        Edit Profile
                    </button>

                    <div class="md:block hidden">
                        <div class="flex items-center text-[18px]">
                            <div class="mr-6">
                                <span class="font-extrabold">{{ postsByUser.data.length }}</span>  posts
                            </div>
                            <!-- <div class="mr-6">
                                <span class="font-extrabold">{{ followerCount }}</span>  followers
                            </div>
                            <div class="mr-6">
                                <span class="font-extrabold">{{ followingCount }}</span>  following
                            </div> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="md:hidden">
            <div class="w-full flex items-center justify-around border-t border-t-gray-300 mt-8">
                <div class="text-center p-3">
                    <div class="font-extrabold">{{ postsByUser.data.length }}</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">posts</div>
                </div>
                <!-- <div class="text-center p-3">
                    <div class="font-extrabold">43</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">followers</div>
                </div>
                <div class="text-center p-3">
                    <div class="font-extrabold">55</div>
                    <div class="text-gray-400 font-semibold -mt-1.5">following</div>
                </div> -->
            </div>

            <!-- <div class="w-full flex items-center justify-between border-t border-t-gray-300">
                <div class="p-3 w-1/4 flex justify-center border-t border-t-gray-900">
                    <Grid :size="28" fillColor="#0095F6" class="cursor-pointer"/>
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <PlayBoxOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer"/>
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <BookmarkOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer"/>
                </div>
                <div class="p-3 w-1/4 flex justify-center">
                    <AccountBoxOutline :size="28" fillColor="#8E8E8E" class="cursor-pointer"/>
                </div>
            </div>-->
        </div> 

        <div id="ContentSection" class="md:pr-1.5 lg:pl-0 md:pl-[90px]">
            <div class="md:block mt-10 hidden border-t border-t-gray-300">
                <div class="flex items-center justify-between max-w-[600px] mx-auto font-extrabold text-gray-400 text-[15px]">
                    <div class="p-[17px] w-1/4 flex justify-center items-center border-t border-t-gray-900">
                        <Grid :size="15" fillColor="#000000" class="cursor-pointer"/>
                        <div class="ml-2 -mb-[1px] text-gray-900">POSTS</div>
                    </div>
                </div>
            </div>

            <div class="grid md:gap-4 gap-1 grid-cols-3 relative">
                <div v-for="postByUser in postsByUser.data" :key="postByUser">
                    <ContentOverlay
                        :postByUser="postByUser"
                        @selectedPost="data.post = $event"
                    />
                </div>
            </div>

            <div class="pb-20"></div>
        </div>
    </MainLayout>

    <ShowPostOverlay
        v-if="data.post"
        :post="data.post"
        @addComment="addComment($event)"
        @updateLike="updateLike($event)"
        @deleteSelected="
            deleteFunc($event);
        "
        @closeOverlay="data.post = null"
    />
</template>
