<template>
    <div v-if="people?.length" class="mt-5 mb-10 text-gray-600">
        <div class="mb-2 text-xl">
            <h1>Successfully uploaded {{ people.length }} records</h1>
        </div>
        <div class="">
            <table class="w-full divide-y divide-gray-300 table-auto">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-left">Title</th>
                        <th class="text-left">Initial</th>
                        <th class="text-left">First Name</th>
                        <th class="text-left">Last Name</th>
                        <th class="text-left">Full Name</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    <tr v-for="(person, index) in people" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ person.title }}</td>
                        <td>{{ person.initial ?? "" }}</td>
                        <td>{{ person.first_name ?? "" }}</td>
                        <td>{{ person.last_name }}</td>
                        <td>
                            {{
                                `${person.title} ${person.initial ?? ""} ${
                                    person.first_name ?? ""
                                } ${person.last_name}`
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { computed } from "vue";

export default {
    props: {
        people: Array,
    },
    setup(props) {
        const people = computed(() => props.people);

        return {
            people,
        };
    },
};
</script>

<style lang="scss" scoped></style>
