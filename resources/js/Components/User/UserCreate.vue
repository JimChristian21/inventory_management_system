<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from '../SecondaryButton.vue';

const props = defineProps({
    errors: {
        type: Object,
        default: {
            name: null,
            roles: null,
            email: null,
            password: null,
            password_confirmation: null
        }
    }
});

const form = useForm({
    name: '',
    roles: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('user.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit" class="rounded-lg">
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
                />

                <InputError v-if="props.errors.name" class="mt-2" :message="props.errors.name" />
            </div>

            <div>
                <InputLabel for="roles" value="Role" />

                <select id="roles" class="rounded-lg mt-1 block w-full" v-model="form.roles">
                    <option value="" disabled>Please select a role</option>
                    <option value="ADMIN">Administrator</option>
                    <option value="SUPPORT">Support</option>
                </select>

                <InputError v-if="props.errors.roles" class="mt-2" :message="props.errors.roles" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError v-if="props.errors.email" class="mt-2" :message="props.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError v-if="props.errors.password" class="mt-2" :message="props.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    v-if="props.errors.password_confirmation"
                    class="mt-2"
                    :message="props.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>

                <SecondaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="$emit('cancel')"
                >
                    Cancel
                </SecondaryButton>
            </div>
        </form>
    </div>
</template>
