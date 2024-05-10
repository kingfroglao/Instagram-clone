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
    email: user.email,
});


</script>

<style scoped>
/* General layout styles */
section {
    max-width: 500px; /* Adjust based on your layout needs */
    margin: 0 auto;
    padding: 20px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

header {
    margin-bottom: 20px;
}

/* Styles for form elements */
input[type="text"], button, a {
    display: block;
    width: 100%;
    padding: 8px;
    margin-top: 5px; /* Adds a little space between form elements */
}

input[type="text"] {
    background-color: #f9f9f9;
    border: 2px solid #ddd;
    border-radius: 4px;
    height: 40px;
    box-sizing: border-box; /* Includes padding and border in the element's total width and height */
}

PrimaryButton {
    background-color: #0056b3;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

PrimaryButton:hover {
    background-color: #004494;
}

PrimaryButton:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

/* Link styling */
a {
    text-decoration: none;
    color: #007BFF;
    text-align: center;
    margin-top: 10px; /* Adds space above the link */
}

a:hover {
    color: #0056b3;
}

/* Error message styles */
InputError {
    color: red;
    font-size: 14px;
}

/* Transition effects for dynamic elements */
.transition {
    transition: opacity 0.3s ease-in-out;
}

.opacity-0 {
    opacity: 0;
}
</style>


<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Search Friend</h2>
        </header>
        
        <form @submit.prevent="form.post(route('search.users', {name: form.name}))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter a name here..."
                />
                <br>

                <InputError class="mt-2" :message="form.errors.msg" />
            </div>

            <div class="flex items-center gap-4">
                <br>
                <PrimaryButton :disabled="form.processing">Search</PrimaryButton>

                <Link href="/" class="text-gray-500 hover:text-gray-700">Cancel</Link>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                </Transition>
            </div>
        <!-- </form> -->
        </form>
    </section>
</template>
