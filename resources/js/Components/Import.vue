<script setup>

    import PrimaryButton from './PrimaryButton.vue';
    import SecondaryButton from './SecondaryButton.vue';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        route: {
            type: String,
            required: true
        },
        errors: {
            type: Object,
            default: { 
                file: null
            }
        }
    });

    const emit = defineEmits(['cancelImport']);

    const form = useForm({
        file: null
    });

    const submit = () => {

        form.post(props.route), {
            onSuccess: () => {
                form.reset();
                emit('cancelImport');
            }
        };
    };
</script>

<template>
    <div>
        <form @submit.prevent="submit" class="rounded-lg">
            <div>
                <InputLabel for="file" value="File" />

                <input
                    id="file"
                    type="file"
                    class="mt-1 block w-full p-1 border-2 border-slate-400 rounded-lg"
                    @input="form.file = $event.target.files[0]"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError v-if="props.errors.file" class="mt-2" :message="props.errors.file" />
            </div>
            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Import
                </PrimaryButton>

                <SecondaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="$emit('cancelImport')"
                >
                    Cancel
                </SecondaryButton>
            </div>
        </form>
    </div>
</template>