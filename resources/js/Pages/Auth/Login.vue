<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout class="full-screen d-flex flex-column justify-content-center align-items-center" style="background-color: #EDEDED;">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 fs-4 text-success">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="fs-3 shadow-lg p-5 rounded-5" style="backdrop-filter: blur(50px) brightness(120%);">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="d-flex align-items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" class="me-2"/>
                    <span class="ml-2 text-sm text-gray-600">Ricorda</span>
                </label>
            </div>

            <div class="d-flex align-items-center mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="me-4"
                >
                    Password dimenticata ?
                </Link>

                <PrimaryButton class="btn-show border border-2 rounded-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
