<script setup>
import axios from "axios";
import { ref, onMounted, reactive, watch } from "vue";
import { Form, Field, useResetForm } from "vee-validate";
import * as yup from "yup";
import { useToastr } from "../../toastr.js";
import UserListItem from "./TechListItem.vue";
import { debounce } from "lodash";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import { useSettingStore } from "../../stores/SettingStore";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";

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

const getItems = (page = 1) => {
    axios
        .get(`/api/tech-recommendations?page=${page}`, {
            params: {
                query: searchQuery.value,
            },
        })
        .then((response) => {
            lists.value = response.data;
            selectedItems.value = [];
            selectAll.value = false;
        });
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
                        <button
                            @click="addUser"
                            type="button"
                            class="mb-2 btn btn-primary"
                        >
                            <i class="fa fa-plus-circle mr-1"></i>
                            New Task
                        </button>
                    </div>
                    <div class="d-flex">
                        <input
                            type="text"
                            v-model="searchQuery"
                            class="form-control"
                            placeholder="Search..."
                        />
                    </div>
                </div>
                <div class="col-12" id="accordion">
                    <div class="card card-primary">
                        <a
                            class="d-block w-100"
                            data-toggle="collapse"
                            href="#collapseOne"
                        >
                            <div class="card-header">
                                <h4 class="card-title">
                                    <i class="fas fa-calendar-alt"></i>&nbsp;<b
                                        >11/24/2023</b
                                    >
                                </h4>
                                <div class="card-tools">
                                    <button
                                        type="button"
                                        class="btn btn btn-danger float-right btn-secondary"
                                        style="margin-left: 10px"
                                    >
                                        End
                                    </button>
                                    <p class="float-right"></p>
                                    <!---->
                                    <p class="float-right">
                                        11/24/2023 7:27 am
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div
                            id="collapseOne"
                            class="collapse"
                            data-parent="#accordion"
                        >
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <h5>
                                                <b>Site:</b>
                                                SYSU CEBU - TECH SUPPORT
                                            </h5>
                                            <h5>
                                                <b>Project:</b>
                                                N/A
                                            </h5>
                                            <h5>
                                                <b>Planned Date:</b>
                                                11/24/2023 8:00 AM
                                            </h5>
                                            <h5>
                                                <b>Planned End Date:</b>
                                                11/24/2023 5:00 PM
                                            </h5>
                                        </div>

                                        <div class="col-4">
                                            <h5>
                                                <b>Start Date:</b>
                                                11/24/2023 7:27 am
                                            </h5>
                                            <h5><b>Accomplished Date:</b></h5>

                                            <h5 class="closestatus">
                                                <b style="color: black"
                                                    >Type:</b
                                                >
                                                VSC
                                            </h5>
                                        </div>
                                        <div class="col-4">
                                            <h5 class="ongoing">
                                                <b style="color: black"
                                                    >Status:</b
                                                >
                                                ON-GOING
                                            </h5>
                                            <h5>
                                                <b style="color: black"
                                                    >Attachment:</b
                                                >
                                                0
                                            </h5>
                                            <h5 class="closestatus">
                                                <b style="color: black">PWS:</b>
                                                VSC
                                            </h5>

                                            <h5><b>Remarks:</b></h5>
                                        </div>
                                    </div>
                                </div>

                                <div style="margin: 0.5%">
                                    <button
                                        type="button"
                                        class="btn btn btn-danger float-right fa fa-times btn-secondary"
                                        style="
                                            margin-left: 10px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        &nbsp;&nbsp;Drop</button
                                    ><button
                                        type="button"
                                        disabled="disabled"
                                        class="btn btn btn-warning fa fa-pencil-square-o float-left btn-secondary disabled"
                                        style="
                                            margin-right: 5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        &nbsp;&nbsp;Edit</button
                                    ><button
                                        type="button"
                                        class="btn btn btn-success float-left fa fa-file-image-o btn-secondary"
                                        style="
                                            margin-right: 5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        &nbsp;&nbsp;Attachment</button
                                    ><button
                                        type="button"
                                        class="btn btn btn-info float-left fa fa-commenting-o btn-secondary"
                                    >
                                        &nbsp;&nbsp;Remarks
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <a
                            class="d-block w-100"
                            data-toggle="collapse"
                            href="#collapsetwo"
                        >
                            <div class="card-header">
                                <h4 class="card-title">
                                    <i class="fas fa-calendar-alt"></i>&nbsp;<b
                                        >11/25/2023</b
                                    >
                                </h4>
                                <div class="card-tools">
                                    <button
                                        type="button"
                                        disabled="disabled"
                                        class="btn btn btn-danger float-right btn-secondary disabled"
                                        style="margin-left: 10px"
                                    >
                                        End
                                    </button>
                                    <p class="float-right"></p>
                                    <button
                                        type="button"
                                        class="btn btn btn-success float-right btn-secondary"
                                    >
                                        Start
                                    </button>
                                </div>
                            </div>
                        </a>
                        <div
                            id="collapsetwo"
                            class="collapse"
                            data-parent="#accordion"
                        >
                            <div class="card-body">
                                <div class="taskList" style="margin: 1%">
                                    <h5>
                                        <b>Site:</b>
                                        SYSU CEBU - TECH SUPPORT
                                    </h5>
                                    <h5>
                                        <b>Project:</b>
                                        N/A
                                    </h5>
                                    <h5>
                                        <b>Planned Date:</b>
                                        11/24/2023 8:00 AM
                                    </h5>
                                    <h5>
                                        <b>Start Date:</b>
                                        11/24/2023 7:27 am
                                    </h5>
                                    <h5>
                                        <b>Planned End Date:</b>
                                        11/24/2023 5:00 PM
                                    </h5>
                                    <h5 class="ongoing">
                                        <b style="color: black">Status:</b>
                                        ON-GOING
                                    </h5>
                                    <h5>
                                        <b style="color: black">Attachment:</b>
                                        0
                                    </h5>
                                </div>
                                <div class="taskList" style="margin: 1%">
                                    <h5><b>Accomplished Date:</b></h5>
                                    <h5 class="closestatus">
                                        <b style="color: black">Type:</b>
                                        VSC
                                    </h5>
                                    <h5 class="closestatus">
                                        <b style="color: black">PWS:</b>
                                        VSC
                                    </h5>
                                </div>
                                <div style="margin: 1%">
                                    <div class="row my-1">
                                        <div class="col-sm-3">
                                            <h5><b>Remarks:</b></h5>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin: 0.5%">
                                    <button
                                        type="button"
                                        class="btn btn btn-danger float-right fa fa-times btn-secondary"
                                        style="
                                            margin-left: 10px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        &nbsp;&nbsp;Drop</button
                                    ><button
                                        type="button"
                                        disabled="disabled"
                                        class="btn btn btn-warning fa fa-pencil-square-o float-left btn-secondary disabled"
                                        style="
                                            margin-right: 5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        &nbsp;&nbsp;Edit</button
                                    ><button
                                        type="button"
                                        class="btn btn btn-success float-left fa fa-file-image-o btn-secondary"
                                        style="
                                            margin-right: 5px;
                                            margin-bottom: 5px;
                                        "
                                    >
                                        &nbsp;&nbsp;Attachment</button
                                    ><button
                                        type="button"
                                        class="btn btn btn-info float-left fa fa-commenting-o btn-secondary"
                                    >
                                        &nbsp;&nbsp;Remarks
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="FormModal"
        data-backdrop="static"
        tabindex="-1"
        role="dialog"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit Task</span>
                        <span v-else>Add Task</span>
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <Form @submit="handleSubmit" v-slot:default="{ errors }">
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <Field
                                        v-model="form.user_id"
                                        type="hidden"
                                        name="user_id"
                                        id="user_id"
                                    />
                                    <div class="form-group">
                                        <label for="site">Site Name</label>
                                        <Field
                                            v-model="form.site"
                                            name="site"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.site,
                                            }"
                                            id="site"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Site Name"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.site
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="site">Task Type</label>
                                        <Field name="tasktype" >
                                            <select
    v-model="form.tasktype"
                                                class="form-control"
:required="true"
                                            >
                                                <option value="" disabled>
                                                    Select an option
                                                </option>
                                                <option
                                                    v-for="option in taskoptions"
                                                    :key="option.value"
                                                    v-bind:value="option.value"
                                                >
                                                    {{ option.name }}
                                                </option>
                                            </select>
                                        </Field>
                                    </div>
                                    <div class="form-group">
                                        <label for="task">Task</label>
                                        <Field
                                            v-model="form.taskname"
                                            name="taskname"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.taskname,
                                            }"
                                            id="taskname"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Task"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.taskname
                                        }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="end-time"
                                            >Start Date & Time</label
                                        >
                                        <input
                                            v-model="form.plandate"
                                            type="text"
                                            class="form-control flatpickr"
                                            id="plandate"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="end-time"
                                            >End Date & Time</label
                                        >
                                        <input
                                            v-model="form.planenddate"
                                            type="text"
                                            class="form-control flatpickr"
                                            id="planenddate"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
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

    <div
        class="modal fade"
        id="deleteClientModal"
        data-backdrop="static"
        tabindex="-1"
        role="dialog"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span>Delete Record</span>
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this record ?</h5>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button
                        @click.prevent="deleteUser"
                        type="button"
                        class="btn btn-primary"
                    >
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
