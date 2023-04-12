<template>
    <form @submit.prevent="uploadFile" enctype="multipart/form-data">
        <div
            class="flex flex-col items-center justify-center min-h-screen gap-10 bg-gray-200"
        >
            <div
                class="flex flex-col w-[50%] h-[50%] max-w-[900px] max-h-[700px]"
            >
                <div
                    class="flex flex-col items-center p-4 rounded-lg bg-gray-50 min-w-[300px]"
                >
                    <div
                        class="flex flex-col justify-between w-full h-24 mb-5 text-gray-600 self-baseline"
                    >
                        <h1 class="text-xl">Files Upload</h1>
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
                        @drop="onFileDropped"
                        class="z-50 mb-10 flex items-center text-center justify-center w-full p-4 text-2xl text-gray-400 bg-white border-4 border-dashed border-blue-400 rounded-lg h-[400px]"
                        :class="{
                            isDragging: isDragging,
                            hasFile: fileName && !isDragging,
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
                            fileName
                                ? fileName
                                : "Drag & drop here or select file below"
                        }}
                    </div>
                    <div class="flex justify-between w-full">
                        <label
                            class="w-48 px-4 py-2 mr-2 text-lg text-center text-white bg-blue-400 rounded-lg cursor-pointer hover:bg-blue-600"
                            for="file"
                            >Select file</label
                        >
                        <button
                            type="submit"
                            :disabled="!fileName"
                            class="w-48 px-4 py-2 text-lg text-center text-white bg-green-400 border-none rounded-lg cursor-pointer hover:bg-green-600 disabled:opacity-30 disabled:hover:bg-green-400 disabled:cursor-none"
                        >
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

export default {
    setup() {
        const fileInput = ref(null);
        const file = ref(null);
        const isDragging = ref(false);
        const fileName = ref(null);

        const onDragEnter = (event) => {
            isDragging.value = true;
        };
        const onDragLeave = (event) => {
            isDragging.value = false;
        };
        const onFileDropped = (event) => {
            setFile(event);
            isDragging.value = false;
        };
        const onChange = (event) => {
            setFile(event);
        };
        const setFile = (event) => {
            event.preventDefault();
            const { files } = event.dataTransfer || event.target;
            file.value = files[0];
            fileName.value = files[0].name;
            console.log(file.value);
        };
        const uploadFile = () => {
            const form = useForm({
                file,
            });
            form.post(route("file.upload"));
        };

        return {
            uploadFile,
            fileInput,
            file,
            isDragging,
            fileName,
            onFileDropped,
            onDragEnter,
            onDragLeave,
            onChange,
        };
    },
};
</script>

<style>
/* .hidden-input {
    opacity: 0;
    overflow: hidden;
    position: absolute;
    width: 1px;
    height: 1px;
} */
.isDragging {
    background: rgba(96, 165, 250, 0.556);
    border-color: rgb(96 165 250);
    color: white;
}
.hasFile {
    background: #6ee7b7;
    color: white;
    border-color: #10b981;
}
</style>
