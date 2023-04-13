import { mount } from "@vue/test-utils";
import FileUpload from "../../resources/js/Pages/FileUpload.vue";

const wrapper = mount(FileUpload, {
    propsData: {
        people: [],
    },
});

test("renders as expected", async () => {
    expect(FileUpload).toBeTruthy();
    expect(wrapper.html()).toMatchSnapshot();
});
// test("succesfully uploads file", async () => {
//     const file = new File(["homeowner\nJohn Doe\nJane Doe\n"], "test.csv", {
//         type: "text/csv",
//     });
//     const fileInput = wrapper.find("input[type='file']");
//     fileInput.element.file = [file];
//     fileInput.trigger("change");

//     const submitButton = wrapper.find("button[type='submit']");
//     expect(submitButton).not.toBe("disabled");
//     submitButton.trigger("click");
// });
