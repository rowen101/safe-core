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
import { ContentLoader } from "vue-content-loader";

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

const isloading = ref(false);
const editing = ref(false);
const formValues = ref();
const form = ref(null);
const authUserStore = useAuthUserStore();
const selectedStatus = ref(null);
const getItems = (page = 1) => {
    isloading.value = true;
    axios
        .get(`/api/tech-recommendations?page=${page}`, {
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

const createUserSchema = yup.object({
    branch: yup.string().required(),
    department: yup.string().required(),
    user: yup.string().required(),
    problem: yup.string().required(),
    assconducted: yup.string().required(),
    brand: yup.string().required(),
});

const editUserSchema = yup.object({
    branch: yup.string().required(),
    department: yup.string().required(),
    user: yup.string().required(),
    problem: yup.string().required(),
    assconducted: yup.string().required(),
    brand: yup.string().required(),
});

const createData = (values, { resetForm, setErrors }) => {
    axios
        .post("/api/tech-recommendations", values)
        .then((response) => {
            lists.value.data.unshift(response.data);
            $("#FormModal").modal("hide");
            resetForm();
            toastr.success("Data created successfully!");
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        });
};

const addUser = () => {
    editing.value = false;
    $("#FormModal").modal("show");
};

const editData = (item) => {
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

const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
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
    getItems();
});
</script>

<template>
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <button
                        @click="addUser"
                        type="button"
                        class="mb-2 btn btn-primary"
                    >
                        <i class="fa fa-plus-circle mr-1"></i>
                        TechRecom
                    </button>
                    <div v-if="selectedItems.length > 0">
                        <button
                            @click="bulkDelete"
                            type="button"
                            class="ml-2 mb-2 btn btn-danger"
                        >
                            <i class="fa fa-trash mr-1"></i>
                            Delete Selected
                        </button>
                        <span class="ml-2"
                            >Selected
                            {{ selectedItems.length }} techrecomm</span
                        >
                    </div>
                </div>
                <div>
                    <input
                        type="text"
                        v-model="searchQuery"
                        class="form-control"
                        placeholder="Search..."
                    />
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ContentLoader v-if="isloading" viewBox="0 0 250 110">
                        <rect
                            x="0"
                            y="0"
                            rx="3"
                            ry="3"
                            width="250"
                            height="10"
                        />
                        <rect
                            x="0"
                            y="20"
                            rx="3"
                            ry="3"
                            width="250"
                            height="10"
                        />
                        <rect
                            x="0"
                            y="40"
                            rx="3"
                            ry="3"
                            width="250"
                            height="10"
                        />
                        <rect
                            x="0"
                            y="60"
                            rx="3"
                            ry="3"
                            width="250"
                            height="10"
                        />
                    </ContentLoader>
                    <div class="dispatch-table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <!-- <th>
                                    <input
                                        type="checkbox"
                                        v-model="selectAll"
                                        @change="selectAllUsers"
                                    />
                                </th> -->
                                        <th style="width: 10px">#</th>
                                        <th>Technom</th>
                                        <th>User</th>
                                        <th>Branch</th>
                                        <th>Department</th>
                                        <th>Created by</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody v-if="lists.data.length > 0">
                                    <UserListItem
                                        v-for="(item, index) in lists.data"
                                        :key="item.id"
                                        :item="item"
                                        :index="index"
                                        @edit-user="editData"
                                        @show-item="viewItem"
                                        @confirm-user-deletion="
                                            confirmItemDeletion
                                        "
                                        @toggle-selection="toggleSelection"
                                        :select-all="selectAll"
                                    />
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No results found...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div
                        class="dispatch-list"
                        v-for="(item, index) in lists.data"
                        :key="item.id"
                        :item="item"
                        :index="index"
                    >
                        <div class="card">
                            <div class="card-body">
                                <div class="list-field">
                                    <span class="mb-1 dis">Tech #:</span>
                                    <span><b>{{
                                       item.recommnum
                                    }}</b></span>
                                </div>
                                <div class="list-field">
                                    <span class="mb-1 dis">User:</span>
                                    <span>{{
                                     item.user
                                    }}</span>
                                </div>
                                <div class="list-field">
                                    <span class="mb-1 dis">Branch:</span>
                                    <span>{{
                                      item.branch
                                    }}</span>
                                </div>
                                <div class="list-field">
                                    <span class="mb-1 dis">Department:</span>
                                    <span>{{
                                       item.department
                                    }}</span>
                                </div>
                                <div class="list-field">
                                    <span class="mb-1 dis">Created:</span>
                                    <span>{{
                                        item.created_by
                                    }}</span>
                                </div>
                                <div class="list-field">
                                    <span class="mb-1 dis">Status:</span>
                                   <span class="badge" :class="`badge-${item.status.color}`" >{{
                                        item.status.name
                                    }} </span>
                                </div>
                                <div class="list-field">
                                    <span class="mb-1 dis">Created Date:</span>
                                    <span>{{
                                       item.created_at
                                    }}</span>
                                </div>
                                <hr />
                                <div class="row">

                                    <div class="col" v-if="authUserStore.user.role === 'ADMIN'">
                                        <button
                                            variant="primary"
                                            class="btn btnsm btn-primary btn-block"
                                            @click="
                                                editData(
                                                    item
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-pencil-square-o"
                                            ></i>
                                            Edit
                                        </button>
                                        <button
                                            class="btn btnsm btn-danger btn-block"
                                            @click="confirmItemDeletion(item.id)"
                                        >
                                            <span class="text-light">
                                                <i class="fa fa-trash-o"></i>
                                                Remove
                                            </span>
                                        </button>
                                    </div>

                                      <div class="col" v-if="authUserStore.user.role === 'USER'">
                                        <button
                                            variant="primary"
                                            class="btn btnsm btn-primary btn-block"
                                            @click="
                                                editData(
                                                    item
                                                )
                                            "
                                        >
                                            <i
                                                class="fa fa-pencil-square-o"
                                            ></i>
                                            Edit
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Bootstrap4Pagination
                :data="lists"
                @pagination-change-page="getItems"
            />
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit Tech Recom.</span>
                        <span v-else>Add New Tech Recom.</span>
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
                <Form
                    ref="form"
                    @submit="handleSubmit"
                    :validation-schema="
                        editing ? editUserSchema : createUserSchema
                    "
                    v-slot="{ errors }"
                    :initial-values="formValues"
                >
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6">
                                    <Field
                                        type="hidden"
                                        name="created_by"
                                        id="created_by"
                                        v-model="authUserStore.user.id"
                                    />
                                    <div class="form-group">
                                        <label for="user">Branch</label>
                                        <Field
                                            name="branch"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.branch,
                                            }"
                                            id="branch"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter branch"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.branch
                                        }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="department"
                                            >Department</label
                                        >
                                        <Field
                                            name="department"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.department,
                                            }"
                                            id="department"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Department"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.department
                                        }}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="warehouse">warehouse</label>
                                        <Field
                                            name="warehouse"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.warehouse,
                                            }"
                                            id="email"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Warehouse"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.warehouse
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="user">User</label>
                                        <Field
                                            name="user"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.user,
                                            }"
                                            id="user"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter User"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.user
                                        }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="brand">Brand</label>
                                        <Field
                                            name="brand"
                                            type="text"
                                            class="form-control"
                                            id="brand"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter brand"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="model">Model</label>
                                        <Field
                                            name="model"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.model,
                                            }"
                                            id="model"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Model"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.model
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="assettag">Asset tag</label>
                                        <Field
                                            name="assettag"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.assettag,
                                            }"
                                            id="assettag"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Asset Tag"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.assettag
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="serialnum"
                                            >Serial number</label
                                        >
                                        <Field
                                            name="serialnum"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.serialnum,
                                            }"
                                            id="serialnum"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Serial Number"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.serialnum
                                        }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="problem"
                                            >Report Problem</label
                                        >
                                        <Field
                                            name="problem"
                                            as="textarea"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': errors.problem,
                                            }"
                                            id="problem"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Report problem"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.problem
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="assconducted"
                                            >Assessment conducted</label
                                        >
                                        <Field
                                            name="assconducted"
                                            as="textarea"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    errors.assconducted,
                                            }"
                                            id="assconducted"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Assessment conducted"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.assconducted
                                        }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="recommendation"
                                            >Recommendation</label
                                        >
                                        <Field
                                            name="recommendation"
                                            as="textarea"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    errors.recommendation,
                                            }"
                                            id="recommendation"
                                            aria-describedby="nameHelp"
                                            placeholder="Enter Recommendation"
                                        />
                                        <span class="invalid-feedback">{{
                                            errors.recommendation
                                        }}</span>
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
                        Delete Record
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
