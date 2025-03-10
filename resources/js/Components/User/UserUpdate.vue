<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from '../SecondaryButton.vue';

const props = defineProps({
    user: {
        id: {
            type: Number,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        roles: {
            type: String,
            required: true
        }
    },
    errors: {
        type: Object,
        default: { 
            name: null,
            roles: null,
            email: null
        }
    }
});

const emit = defineEmits(['cancelUpdate']);

const form = useForm({
    name: props.user.name,
    roles: props.user.roles[0].code
});

const submit = () => {
    form.patch(route('user.update', props.user.id), {
        onSuccess: () => {
            emit('cancelUpdate');
        }
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

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Update
                </PrimaryButton>

                <SecondaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="$emit('cancelUpdate')"
                >
                    Cancel
                </SecondaryButton>
            </div>
        </form>
    </div>
</template>
