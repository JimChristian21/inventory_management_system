<script setup>

import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from '../SecondaryButton.vue';

const props = defineProps({
    item: {
        name: {
            type: String
        },
        description: {
            type: String
        },
        quantity: {
            type: Number
        },
        critical_quantity: {
            type: Number
        }
    },
    errors: {
        type: Object,
        default: { 
            name: null,
            description: null,
            quantity: null,
            critical_quantity: null
        }
    }
});

const emit = defineEmits(['cancelUpdate']);

const form = useForm({
    name: props.item.name,
    description: props.item.description,
    quantity: props.item.quantity,
    critical_quantity: props.item.critical_quantity
});

const submit = () => {
    form.patch(route('item.update', props.item.id), {
        onSuccess: () => {
            form.reset();
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
                <InputLabel for="description" value="Description" />

                <TextInput
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    autofocus
                    autocomplete="description"
                />

                <InputError v-if="props.errors.description" class="mt-2" :message="props.errors.description" />
            </div>
            <div class="mt-4">
                <InputLabel for="quantity" value="Quantity" />

                <input
                    id="quantity"
                    type="number"
                    class="mt-1 block w-full rounded-lg"
                    min="0"
                    v-model="form.quantity"
                    required
                    autocomplete="quantity"
                />

                <InputError v-if="props.errors.quantity" class="mt-2" :message="props.errors.quantity" />
            </div>
            <div class="mt-4">
                <InputLabel for="critical_quantity" value="Critical Quantity" />

                <input
                    id="critical_quantity"
                    type="number"
                    class="mt-1 block w-full rounded-lg"
                    min="0"
                    v-model="form.critical_quantity"
                    required
                    autocomplete="quantity"
                />

                <InputError v-if="props.errors.critical_quantity" class="mt-2" :message="props.errors.critical_quantity" />
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
