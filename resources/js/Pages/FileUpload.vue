<template>
    <form
        @submit.prevent="uploadFile"
        enctype="multipart/form-data"
        :disabled="form.processing"
    >
        <div
            class="flex flex-col items-center justify-center min-h-screen gap-10 bg-gray-200"
        >
            <div class="flex flex-col w-[70%] max-w-[900px]">
                <div
                    class="flex flex-col items-center p-4 rounded-lg bg-gray-50 min-w-[300px]"
                >
                    <div
                        class="flex flex-col justify-between w-full h-24 mb-5 text-gray-600 self-baseline"
                    >
                        <h1 class="self-center text-xl">Files Upload</h1>
                        <div class="flex justify-between">
                            <div class="flex items-center w-full">
                                Files allowed:
                                <span
                                    ><img
                                        class="w-12 h-12 ml-2"
                                        src="../../assets/csv-icon.png"
                                        alt=""
                                /></span>
                            </div>
                        </div>
                    </div>
                    <div
                        @dragover.prevent
                        @dragenter="onDragEnter"
                        @dragleave="onDragLeave"
                        @drop="onChange"
                        class="z-50 flex items-center text-center justify-center w-full p-4 text-2xl text-gray-400 bg-white border-4 border-dashed border-blue-400 rounded-lg h-[400px]"
                        :class="{
                            isDragging: isDragging,
                            hasFile: file && !isDragging,
                            hasError: error && !isDragging && !file,
                        }"
                    >
                        <input
                            type="file"
                            name="file"
                            id="file"
                            hidden
                            ref="fileInput"
                            @change="onChange"
                            accept=".csv"
                        />
                        {{
                            file
                                ? fileName
                                : isDragging && !file
                                ? "Drop here"
                                : "Drag & drop here or select file below"
                        }}
                    </div>
                    <transition name="fade">
                        <div
                            v-if="error"
                            class="flex justify-center w-full -mb-6 text-red-400"
                        >
                            {{ errorMessage }}
                        </div>
                    </transition>

                    <div
                        v-if="file"
                        @click="removeFile"
                        class="flex justify-end w-full -mb-6 cursor-pointer"
                    >
                        <span><u>Remove file</u></span>
                    </div>
                    <div
                        class="flex flex-col justify-between w-full md:flex-row mt-14"
                    >
                        <label
                            class="w-full px-4 py-2 mb-2 mr-2 text-lg text-center text-white bg-blue-400 rounded-lg cursor-pointer md:mb-0 md:w-48 hover:bg-blue-600 active:bg-blue-900"
                            for="file"
                            >Select file</label
                        >
                        <button
                            :disabled="!file || processing"
                            type="submit"
                            class="w-full px-4 py-2 text-lg text-center text-white bg-green-400 border-none rounded-lg cursor-pointer md:w-48 hover:bg-green-600 active:bg-green-800 disabled:opacity-30 disabled:hover:bg-green-400"
                        >
                            Upload
                        </button>
                    </div>
                </div>
                <div class="mt-10 text-center" v-if="form.processing">
                    Uploading data...
                </div>
                <people-table
                    v-if="people?.length && !form.processing"
                    :people="people"
                />
            </div>
        </div>
    </form>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import { computed, reactive, ref } from "vue";
import PeopleTable from "../Components/PeopleTable.vue";

export default {
    name: "file-upload",
    components: {
        PeopleTable,
    },
    props: {
        people: Array,
    },
    setup(props) {
        const fileInput = ref(null);
        const file = ref(null);
        const isDragging = ref(false);
        const fileName = ref(null);
        const form = useForm({
            file,
        });
        const progress = computed(() => form.progress);
        const processing = computed(() => form.processing);
        const people = computed(() => props.people);
        const error = ref(false);
        const errorMessage = ref("");

        const onDragEnter = (event) => {
            isDragging.value = true;
        };
        const onDragLeave = (event) => {
            isDragging.value = false;
        };
        const onChange = async (event) => {
            event.preventDefault();
            isDragging.value = false;

            const { files } = event.dataTransfer || event.target;

            let validated = await validateFile(files[0]);

            if (!validated) {
                showError();
            } else {
                file.value = files[0];
                fileName.value = files[0].name;
            }
            event.target.value = "";
        };
        const validateFile = async (file) => {
            if (file?.type != "text/csv") {
                return false;
            } else {
                return true;
            }
        };
        const uploadFile = () => {
            form.post(route("file.upload"), {
                preserveScroll: true,
                onSuccess: () => success(),
                onError: (err) => showError(err),
            });
        };
        const showError = (err) => {
            error.value = true;
            if (err) {
                errorMessage.value = err.file;
            } else {
                errorMessage.value = "Invalid file type";
            }
            setTimeout(() => {
                error.value = false;
                errorMessage.value = "";
            }, 2000);
        };
        const success = () => {
            file.value = null;
            fileName.value = null;
        };
        const removeFile = () => {
            file.value = null;
            fileName.value = null;
        };

        return {
            uploadFile,
            fileInput,
            file,
            isDragging,
            fileName,
            onDragEnter,
            onDragLeave,
            onChange,
            form,
            people,
            removeFile,
            progress,
            processing,
            error,
            errorMessage,
        };
    },
};
</script>

<style>
.isDragging {
    background: #60a5fa8e;
    border-color: #60a5fa;
    color: white;
}
.hasFile {
    background: #6ee7b7;
    color: white;
    border-color: #10b981;
}
.hasError {
    animation: fadeBack 7s ease-out forwards;
}

/* ANIMATIONS */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}

@keyframes fadeBack {
    0% {
        border-color: #f87171;
    }
    100% {
        border-color: #60a5fa;
    }
}
</style>
