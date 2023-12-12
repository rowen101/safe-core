<script setup>
import axios from "axios";
import { ref, onMounted, reactive, watch } from "vue";
import { Form, Field, useResetForm } from "vee-validate";
import * as yup from "yup";
import { useToastr } from "../../toastr.js";
import WtsListItem from "./WtsListItem.vue";
import { debounce } from "lodash";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import { useSettingStore } from "../../stores/SettingStore";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import moment from "moment";
import { inject } from "vue";
import { ContentLoader } from 'vue-content-loader'

const isloading = ref(false);
const swal = inject("$swal");
const settingStore = useSettingStore();
const toastr = useToastr();
const lists = ref({ data: [] });
const tecstatus = ref([
    {
        name: "PENDING",
        value: 1,
    },
    {
        name: "APPROVED",
        value: 2,
    },
    {
        name: "CANCELLED",
        value: 3,
    },
]);

const editing = ref(false);
const editingtask = ref(false);
const formValues = ref();

const authUserStore = useAuthUserStore();
const selectedStatus = ref(null);
const showTaskList = ref(false);
const taskoptions = ref([
    {
        name: "LEAVE",
        value: 1,
    },
    {
        name: "ON BUSINESS TRAVEL",
        value: 2,
    },
    {
        name: "SITE VISIT",
        value: 3,
    },
    {
        name: "VSC",
        value: 4,
    },
    {
        name: "WORK FROM HOME",
        value: 6,
    },
]);

const form = reactive({
    site: "",
    user_id: authUserStore.user.id,
    tasktype: 0,
    taskname: "",
    plandate: "",
    planenddate: "",
});
//task
const formtask = ref({
    dailytask_id: '',
    tasks: [{ task_name: '', errors: false }],
});

const getItems = () => {
    isloading.value = true;
    axios
        .get(`/api/dailytask`, {
            params: {
                query: searchQuery.value,
            },
        })
        .then((response) => {
            isloading.value = false;
            lists.value = response.data;
            selectedItems.value = [];
            selectAll.value = false;

        });
};


const OpenModalTask = () => {

    $("#FormModalTask").modal("show");

}

const showTasks = (value) => {
    formtask.value.dailytask_id = value.id;
    // Fetch tasks based on dailytask_id
    axios.get(`/api/dailytask/${value.id}/tasks`)
        .then(response => {
            formtask.value.tasks = response.data.map(task => ({ task_name: task.task_name, errors: false }));
            OpenModalTask();
        })
        .catch(error => {
            console.error("Error fetching tasks:", error);
            // Handle the error appropriately, e.g., show an error message
        });
};



const AddNewTask = () => {
    axios
        .post("/api/dailytask/addnewTask", {
            dailytask_id: formtask.value.dailytask_id,
            tasks: formtask.value.tasks,
        })
        .then((response) => {
            $("#FormModalTask").modal("hide");
            toastr.success("Data created successfully!");

            // Clear formtask after successful save
            formtask.value.dailytask_id = "";
            formtask.value.tasks = [{ task_name: '', errors: false }];

        })
        .catch((error) => {
            console.error("Error adding new task:", error);
            toastr.error("Error adding new task. Please try again.");
        });
};



const addTask = (index) => {

    if (formtask.value.tasks[index].task_name.trim() !== '') {
        // Add a new task at the specified index
        formtask.value.tasks.splice(index + 1, 0, { task_name: '', errors: false });
    }
};


const removeTask = (index) => {
    if (index > 0) {
        formtask.value.tasks.splice(index, 1);
    }
};



const createDataSchema = yup.object({
    site: yup.string().required(),
    tasktype: yup.string().required(),
    taskname: yup.string().required(),
    plandate: yup.string().required(),
    planenddate: yup.string().required(),
});

const editDataSchema = yup.object({
    site: yup.string().required(),
    tasktype: yup.string().required(),
    taskname: yup.string().required(),
    plandate: yup.string().required(),
    planenddate: yup.string().required(),
});

const createData = (values, actions) => {
    axios
        .post("/api/dailytask", form)
        .then((response) => {
            lists.value.data.unshift(response.data);
            $("#FormModal").modal("hide");

            toastr.success("data created successfully!");
        })
        .catch((error) => {
            actions.setErrors(error.response.data.errors);
        });
};

const addUser = () => {
    editing.value = false;
    $("#FormModal").modal("show");
};

const editUser = (item) => {
    editing.value = true;
    form.value.resetForm();
    $("#FormModal").modal("show");
    formValues.value = {
        id: item.id,
        recommnum: item.recommnum,
        company: item.company,
        branch: item.branch,
        department: item.department,
        warehouse: item.warehouse,
        user: item.user,
        problem: item.problem,
        brand: item.brand,
        model: item.model,
        assettag: item.assettag,
        serialnum: item.serialnum,
        assconducted: item.assconducted,
        recommendation: item.recommendation,
        ceated_by: item.created_by,
    };
};

const viewItem = (item) => {
    // editing.value = true;
    // form.value.resetForm();
    $("#FormModalView").modal("show");
    formValues.value = {
        id: item.id,
        recommnum: item.recommnum,
        company: item.company,
        branch: item.branch,
        department: item.department,
        warehouse: item.warehouse,
        user: item.user,
        status: item.status.name,
        problem: item.problem,
        brand: item.brand,
        model: item.model,
        assettag: item.assettag,
        serialnum: item.serialnum,
        assconducted: item.assconducted,
        recommendation: item.recommendation,
        ceated_by: item.created_by,
    };
};

const updateData = (values, { setErrors }) => {
    axios
        .put("/api/tech-recommendations/" + formValues.value.id, values)
        .then((response) => {
            const index = lists.value.data.findIndex(
                (item) => item.id === response.data.id
            );
            lists.value.data[index] = response.data;
            $("#FormModal").modal("hide");
            toastr.success("successfully Updated!");
        })
        .catch((error) => {
            setErrors(error.response.data.errors);
            console.log(error);
        });
};
const editMode = ref(false);
const handleSubmit = (values, actions) => {
    if (editMode.value) {
        updateData(values, actions);
    } else {
        createData(values, actions);
    }
};

//start date
const startTaskhandle = async (task) => {
    // Show the SweetAlert2 dialog
    const result = await swal({
        title: "Are you sure?",
        text: "You wanna start your task now?",
        icon: "warning",
        showCancelButton: true,
    });

    // Check if the user confirmed
    if (result.isConfirmed) {
        try {
            // Make the axios PUT request
            const response = await axios.put(
                `/api/dailytask/onhandler/` + task.id,
                task
            );

            // Handle the response
            toastr.success(response.data.message);

            // Refresh your data or perform any other actions
            getItems();
        } catch (error) {
            console.error(error);
            // Handle the error if needed
            toastr.error("An error occurred while updating the task.");
        }
    }
};

//end start
const endTaskhandle = async (task) => {
    // Show the SweetAlert2 dialog
    const result = await swal({
        title: "Are you sure?",
        text: "You wanna end your task now?",
        icon: "warning",
        showCancelButton: true,
    });

    // Check if the user confirmed
    if (result.isConfirmed) {
        try {
            const endstart =
                moment(task.taskdate).format("YYYY-MM-DD") ===
                moment().format("YYYY-MM-DD");

            if (endstart) {
                // If taskdate is the same as the current date and time, set status to "HIT"
                task.status = "HIT";
            } else {
                // If taskdate is different from the current date and time, set status to "MISS"
                task.status = "MISS";
            }
            // Make the axios PUT request
            const response = await axios.put(
                `/api/dailytask/onhandler/` + task.id,
                task
            );

            // Handle the response
            toastr.success(response.data.message);

            // Refresh your data or perform any other actions
            getItems();
        } catch (error) {
            console.error(error);
            // Handle the error if needed
            toastr.error("An error occurred while updating the task.");
        }
    }
};

const searchQuery = ref(null);

const selectedItems = ref([]);
const toggleSelection = (user) => {
    const index = selectedItems.value.indexOf(user.id);
    if (index === -1) {
        selectedItems.value.push(user.id);
    } else {
        selectedItems.value.splice(index, 1);
    }
    console.log(selectedItems.value);
};

const userIdBeingDeleted = ref(null);

const confirmItemDeletion = (id) => {
    userIdBeingDeleted.value = id;
    $("#deleteClientModal").modal("show");
};

const deleteUser = () => {
    axios
        .delete(`/api/tech-recommendations/${userIdBeingDeleted.value}`)
        .then(() => {
            $("#deleteClientModal").modal("hide");
            toastr.success("Client deleted successfully!");
            lists.value.data = lists.value.data.filter(
                (user) => user.id !== userIdBeingDeleted.value
            );
        });
};

const bulkDelete = () => {
    axios
        .delete("/api/tech-recommendations", {
            data: {
                ids: selectedItems.value,
            },
        })
        .then((response) => {
            lists.value.data = lists.value.data.filter(
                (user) => !selectedItems.value.includes(user.id)
            );
            selectedItems.value = [];
            selectAll.value = false;
            toastr.success(response.data.message);
        });
};

const toggleTaskList = () => {
    showTaskList.value = !showTaskList.value;
};

const selectAll = ref(false);

const selectAllUsers = () => {
    if (selectAll.value) {
        selectedItems.value = lists.value.data.map((user) => user.id);
    } else {
        selectedItems.value = [];
    }
    console.log(selectedItems.value);
};

const updateStatus = (status) => {
    selectedStatus.value = status;
};

watch(
    searchQuery,
    debounce(() => {
        getItems();
    }, 300)
);

onMounted(() => {
    flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
    getItems();
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>
                        {{
                            authUserStore.user.first_name +
                            " " +
                            authUserStore.user.last_name
                        }}
                        - My Prio
                    </h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">My Prio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <button @click="addUser" type="button" class="mb-2 btn btn-primary">
                            <i class="fa fa-plus-circle mr-1"></i>
                            New Task
                        </button>
                    </div>
                    <div class="d-flex">
                        <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
                    </div>
                </div>
                <div class="col-12" id="accordion">
                    <ContentLoader v-if="isloading" viewBox="0 0 250 110">
                        <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                        <rect x="0" y="20" rx="3" ry="3" width="250" height="10" />
                        <rect x="0" y="40" rx="3" ry="3" width="250" height="10" />
                        <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                    </ContentLoader>
                    <div v-else>
                        <div v-if="lists.length === 0">
                            <!-- Show this card when the list is empty -->
                            <div class="card card-secondary">
                                <div class="card-body">
                                    <h2 class="text-center">No Prio</h2>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="card card-primary" v-for="task in lists" :key="task.id">
                                <div class="card-header bg-white">
                                    <h4 class="card-title">
                                        <a style="
                                            color: #2b2b2b;
                                            text-decoration: none;
                                        " data-toggle="collapse" :href="'#collapse' + task.id">
                                            <i class="fas fa-calendar-alt"></i>&nbsp;<b>{{
                                                moment(task.taskdate).format(
                                                    "MMMM D, YYYY"
                                                )
                                            }}</b>
                                        </a>
                                    </h4>
                                    <div class="card-tools">
                                        <button v-if="!task.startdate" type="button"
                                            class="btn btn-sm btn-primary float-right" style="margin-left: 10px"
                                            @click="showTasks(task)">
                                            <i class="fas fa-tasks"></i>
                                        </button>
                                        <button :disabled="task.startdate === null" type="button"
                                            class="btn btn-sm btn-danger float-right" style="margin-left: 10px"
                                            @click="endTaskhandle(task)">
                                            End
                                        </button>

                                        <button v-if="!task.startdate" type="button"
                                            class="btn btn-sm btn-success float-right" style="margin-left: 10px"
                                            @click="startTaskhandle(task)">
                                            Start
                                        </button>
                                        <p class="float-right"></p>

                                        <!-- <p class="float-right" v-if="task.startdate">
                                    {{ task.startdate }}
                                </p> -->
                                    </div>
                                </div>

                                <div :id="'collapse' + task.id" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-4">
                                                    <h5>
                                                        <b>Site:</b>
                                                        {{ task.site }}
                                                    </h5>
                                                    <h5>
                                                        <b>Project:</b>
                                                        {{ task.project }}
                                                    </h5>
                                                    <h5>
                                                        <b>Planned Date:</b>
                                                        {{
                                                            moment(
                                                                task.plandate
                                                            ).format(
                                                                "MMMM D, YYYY h:mm A"
                                                            )
                                                        }}
                                                    </h5>
                                                    <h5>
                                                        <b>Planned End Date:</b>
                                                        {{
                                                            moment(
                                                                task.planenddate
                                                            ).format(
                                                                "MMMM D, YYYY h:mm A"
                                                            )
                                                        }}
                                                    </h5>
                                                </div>

                                                <div class="col-4">
                                                    <h5>
                                                        <b>Start Date:</b>
                                                        {{
                                                            task.startdate !== null
                                                            ? moment(
                                                                task.startdate
                                                            ).format(
                                                                "MMMM D, YYYY, h:mm A"
                                                            )
                                                            : ""
                                                        }}
                                                    </h5>
                                                    <h5>
                                                        <b>Accomplished Date:</b>
                                                        {{
                                                            task.enddate !== null
                                                            ? moment(
                                                                task.enddate
                                                            ).format(
                                                                "MMMM D, YYYY, h:mm A"
                                                            )
                                                            : ""
                                                        }}
                                                    </h5>

                                                    <h5 class="closestatus">
                                                        <b style="color: black">Type:</b>
                                                        {{ task.tasktype }}
                                                    </h5>
                                                </div>
                                                <div class="col-4">
                                                    <h5 class="ongoing">
                                                        <b style="color: black">Status:</b>
                                                        {{ task.status }}
                                                    </h5>
                                                    <h5>
                                                        <b style="color: black">Attachment:</b>
                                                        {{ task.attachment }}
                                                    </h5>
                                                    <h5 class="closestatus">
                                                        <b style="color: black">PWS:</b>
                                                        {{ task.PWS }}
                                                    </h5>

                                                    <h5>
                                                        <b>Remarks:</b>
                                                        {{ task.remarks }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="margin: 0.5%">
                                            <button :disabled="task.startdate !== null" type="button"
                                                class="btn btn btn-danger float-right fa fa-trash" style="
                                                margin-left: 10px;
                                                margin-bottom: 5px;
                                            ">
                                                &nbsp;Drop</button><button type="button" :disabled="task.startdate !== null"
                                                class="btn btn btn-danger far fa-edit float-left" style="
                                                margin-right: 5px;
                                                margin-bottom: 5px;
                                            ">
                                                &nbsp;&nbsp;Edit</button><button type="button"
                                                class="btn btn float-left fa fa-file btn-primary" style="
                                                margin-right: 5px;
                                                margin-bottom: 5px;
                                            ">
                                                &nbsp;&nbsp;Attachment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FormModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit My Scheduled</span>
                        <span v-else>Add My Scheduled</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <Form @submit="handleSubmit" v-slot:default="{ errors }">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <Field v-model="form.user_id" type="hidden" name="user_id" id="user_id" />
                                    <div class="form-group">
                                        <label for="site">Site Name</label>
                                        <Field v-model="form.site" name="site" type="text" class="form-control" :class="{
                                            'is-invalid': errors.site,
                                        }" id="site" aria-describedby="nameHelp" placeholder="Enter Site Name" />
                                        <span class="invalid-feedback">{{
                                            errors.site
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="site">Type</label>
                                        <Field name="tasktype">
                                            <select v-model="form.tasktype" class="form-control" :required="true">
                                                <option value="" disabled>
                                                    Select an option
                                                </option>
                                                <option v-for="option in taskoptions" :key="option.value"
                                                    v-bind:value="option.value">
                                                    {{ option.name }}
                                                </option>
                                            </select>
                                        </Field>
                                    </div>
                                    <div class="form-group">
                                        <label for="task">Task</label>
                                        <Field v-model="form.taskname" name="taskname" type="text" class="form-control"
                                            :class="{
                                                'is-invalid': errors.taskname,
                                            }" id="taskname" aria-describedby="nameHelp" placeholder="Enter Task" />
                                        <span class="invalid-feedback">{{
                                            errors.taskname
                                        }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="end-time">Start Date & Time</label>
                                        <input v-model="form.plandate" type="text" class="form-control flatpickr"
                                            id="plandate" />
                                    </div>
                                    <div class="form-group">
                                        <label for="end-time">End Date & Time</label>
                                        <input v-model="form.planenddate" type="text" class="form-control flatpickr"
                                            id="planenddate" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="FormModalTask" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">

                        <span>My Task {{ formtask.dailytask_id }}</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <Form @submit="AddNewTask" v-slot:default="{ errors }">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <Field v-model="formtask.dailytask_id" type="hidden" name="dailytask_id"
                                        id="dailytask_id" />
                                    <div v-for="(task, index) in formtask.tasks" :key="index">
                                        <div style="display: flex; align-items: center;">
                                            <Field v-model="task.task_name" :name="'task_name' + index" type="text"
                                                class="form-control" :class="{ 'is-invalid': task.errors, 'mb-2': true }"
                                                :id="'task_name' + index" :aria-describedby="'nameHelp' + index"
                                                :placeholder="'Enter Task ' + (index + 1)" style="margin-right: 5px;" />


                                            <i class="fas fa-plus-circle" style="font-size: 24px; cursor: pointer;"
                                                    @click="addTask(index)"></i>
                                                <i class="fas fa-minus-circle" style="font-size: 24px; cursor: pointer;"
                                                    @click="removeTask(index)"></i>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteClientModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span>Delete Record</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this record ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button @click.prevent="deleteUser" type="button" class="btn btn-primary">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
a {
    color: #2b2b2b;
    text-decoration: none;
}
</style>
