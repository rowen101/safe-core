<script setup>
import axios from 'axios';
import { ref, onMounted, reactive, watch } from 'vue';
import { Form, Field, useResetForm } from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../../toastr.js';
import UserMenuListItem from './UserMenuListItem.vue';
import { debounce } from 'lodash';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';

const toastr = useToastr();
const users = ref({'data': []});
const editing = ref(false);
const formValues = ref();
const form = ref(null);
const modalname = ref(null)

const getUsers = (page = 1) => {
    axios.get(`/api/users?page=${page}`, {
        params: {
            query: searchQuery.value
        }
    })
    .then((response) => {
        users.value = response.data;
        selectedUsers.value = [];
        selectAll.value = false;
    })
}

const createUserSchema = yup.object({
    username: yup.string().required(),
    last_name: yup.string().required(),
    first_name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().required().min(8),
});

const editUserSchema = yup.object({
    username: yup.string().required(),
    last_name: yup.string().required(),
    first_name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().when((password, schema) => {
        return password ? schema.required().min(8) : schema;
    }),
});

const createUser = (values, { resetForm, setErrors }) => {
    axios.post('/api/users', values)
        .then((response) => {
            users.value.data.unshift(response.data);
            $('#userFormModal').modal('hide');
            resetForm();
            toastr.success('User created successfully!');
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors);
            }
        })
};

const addUser = () => {
    editing.value = false;
    $('#userFormModal').modal('show');
};

const editUser = (user) => {
    getmenu();
    editing.value = true;
    form.value.resetForm();
    $('#userFormModal').modal('show');
  formValues.value = {
        id: user.id,
        username: user.username,
        email: user.email,
        first_name: user.first_name,
        last_name: user.last_name
    };
    modalname.value = formValues.value.first_name +' '+ formValues.value.last_name;

};

const updateUser = (values, { setErrors }) => {
    axios.put('/api/users/' + formValues.value.id, values)
        .then((response) => {
            const index = users.value.data.findIndex(user => user.id === response.data.id);
            users.value.data[index] = response.data;
            $('#userFormModal').modal('hide');
            toastr.success('User updated successfully!');
        }).catch((error) => {
            setErrors(error.response.data.errors);
            console.log(error);
        });
}

const handleSubmit = (values, actions) => {
    // console.log(actions);
    if (editing.value) {
        updateUser(values, actions);
    } else {
        createUser(values, actions);
    }
}

const searchQuery = ref(null);

const selectedUsers = ref([]);
const toggleSelection = (user) => {
    const index = selectedUsers.value.indexOf(user.id);
    if (index === -1) {
        selectedUsers.value.push(user.id);
    } else {
        selectedUsers.value.splice(index, 1);
    }
    console.log(selectedUsers.value);
};

const userIdBeingDeleted = ref(null);
const confirmUserDeletion = (id) => {
    userIdBeingDeleted.value = id;
    $('#deleteUserModal').modal('show');
};

const deleteUser = () => {
    axios.delete(`/api/users/${userIdBeingDeleted.value}`)
    .then(() => {
        $('#deleteUserModal').modal('hide');
        toastr.success('User deleted successfully!');
        users.value.data = users.value.data.filter(user => user.id !== userIdBeingDeleted.value);
    });
};

const bulkDelete = () => {
    axios.delete('/api/users', {
        data: {
            ids: selectedUsers.value
        }
    })
    .then(response => {
        users.value.data = users.value.data.filter(user => !selectedUsers.value.includes(user.id));
        selectedUsers.value = [];
        selectAll.value = false;
        toastr.success(response.data.message);
    });
};

const selectAll = ref(false);
const selectAllUsers = () => {
    if (selectAll.value) {
        selectedUsers.value = users.value.data.map(user => user.id);
    } else {
        selectedUsers.value = [];
    }
    console.log(selectedUsers.value);
}

const menulist = ref({ data: [] });

const getmenu = () => {
    axios
        .get("/api/menu/usermenu")
        .then((response) => {
            menulist.value = response.data;
            console.log(response.data);
        })
        .catch((error) => {
            console.log(error);
        });
};

watch(searchQuery, debounce(() => {
    getUsers();
}, 300));

onMounted(() => {
    getUsers();
    getmenu();
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <button @click="addUser" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle mr-1"></i>
                        Add New User
                    </button>
                    <div v-if="selectedUsers.length > 0">
                        <button @click="bulkDelete" type="button" class="ml-2 mb-2 btn btn-danger">
                            <i class="fa fa-trash mr-1"></i>
                            Delete Selected
                        </button>
                        <span class="ml-2">Selected {{ selectedUsers.length }} users</span>
                    </div>
                </div>
                <div>
                    <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th><input type="checkbox" v-model="selectAll" @change="selectAllUsers" /></th>
                                <th style="width: 10px">#</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Registered Date</th>

                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="users.data.length > 0">
                            <UserMenuListItem v-for="(user, index) in users.data"
                                :key="user.id"
                                :user=user :index=index
                                @edit-user="editUser"
                                @confirm-user-deletion="confirmUserDeletion"
                                @toggle-selection="toggleSelection"
                                :select-all="selectAll" />
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="7" class="text-center">No results found...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Bootstrap4Pagination :data="users" @pagination-change-page="getUsers" />
        </div>
    </div>

    <div class="modal fade" id="userFormModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-l" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">User Menu for {{modalname}}</span>

                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editUserSchema : createUserSchema"
                    :initial-values="formValues">
                    <div class="modal-body">
                      <b-list-group>
                        <b-list-group-item
                            v-for="item in menulist"
                            :key="item.id"
                            :class="{
                            'has-submenu': item.submenus && item.submenus.length > 0,
                            }"
                        >
                            <router-link :to="`${item.menu_route}`">
                            <i :class="'nav-icon ' + item.menu_icon"></i>
                            {{ item.menu_title }}
                            <i
                                v-if="item.submenus && item.submenus.length > 0"
                                class="fas fa-angle-left right"
                            ></i>
                            </router-link>

                            <b-list-group
                            v-if="item.submenus && item.submenus.length > 0"
                            >
                            <b-list-group-item
                                v-for="submenu in item.submenus"
                                :key="submenu.id"
                            >
                                <router-link :to="submenu.menu_route">
                                <i :class="'nav-icon ' + submenu.menu_icon"></i>
                                {{ submenu.menu_title }}
                                </router-link>
                            </b-list-group-item>
                            </b-list-group>
                        </b-list-group-item>
                    </b-list-group>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span>Delete User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this user ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click.prevent="deleteUser" type="button" class="btn btn-primary">Delete User</button>
                </div>
            </div>
        </div>
    </div>
</template>