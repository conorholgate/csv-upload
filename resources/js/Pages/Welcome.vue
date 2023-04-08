<template>
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex flex-col items-center">
            <form @submit.prevent="uploadFile" enctype="multipart/form-data">
                <input type="file" ref="fileInput" accept=".csv" />
                <button type="submit">Upload CSV</button>
            </form>
        </div>
    </div>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

export default {
    setup() {
        const fileInput = ref(null);

        const uploadFile = () => {
            const file = fileInput.value.files[0];
            const form = useForm({
                file,
            });
            if (!file) {
                alert("Please select a file");
                return;
            }
            form.post(route("file.upload"), {
                onSuccess: () => form.reset(),
                onError: () => {
                    console.log("error");
                },
            });
        };

        return {
            uploadFile,
            fileInput,
        };
    },
};
</script>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
