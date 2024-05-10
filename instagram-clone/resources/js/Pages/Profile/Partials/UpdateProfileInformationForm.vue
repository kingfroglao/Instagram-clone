<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: '',
    email: '',
});
</script>
<style scoped>
    section {
        max-width: 600px; /* Adjust based on your layout preferences */
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        color: #333;
    }

    header {
        margin-bottom: 20px;
    }

    header h2 {
        color: #2c3e50;
        font-size: 22px;
    }

    p.text-sm {
        font-size: 14px;
        color: #666;
    }

    /* Input and Label Styles */
    InputLabel, input[type="text"], input[type="email"], PrimaryButton, Link {
        display: block;
        width: 100%;
    }

    input[type="text"], input[type="email"] {
        padding: 10px;
        margin-top: 8px;
        background-color: #f9f9f9;
        border: 2px solid #eaeaea;
        border-radius: 4px;
        height: 40px;
    }

    InputLabel {
        margin-bottom: 5px;
        font-weight: 500;
        color: #34495e;
    }

    /* Button Styles */
    PrimaryButton {
        margin-top: 20px;
        background-color: #3498db;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        text-align: center;
    }

    PrimaryButton:hover {
        background-color: #2980b9;
    }

    PrimaryButton:disabled {
        background-color: #bdc3c7;
        cursor: default;
    }

    /* Link Styling */
    Link {
        text-decoration: none;
        color: #3498db;
        margin-top: 15px;
        text-align: center;
    }

    Link:hover {
        color: #2980b9;
    }

    /* Error Message Styles */
    InputError {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 2px;
    }

    /* Success Message Styles */
    .transition p {
        color: #2ecc71;
        font-size: 14px;
        transition: opacity 0.3s ease-in-out;
    }

    .opacity-0 {
        opacity: 0;
    }
</style>


<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Edit Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name (*requied)" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter new name here..."
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email (*requied)" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="Enter new email here..."
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <!-- <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div> -->
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Link href="/" class="text-gray-500 hover:text-gray-700">Cancel</Link>


                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
