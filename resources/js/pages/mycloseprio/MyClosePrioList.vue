<script setup>
import axios from "axios";
import { ref, onMounted, reactive, watch } from "vue";
import { Form, Field, useResetForm } from "vee-validate";
import * as yup from "yup";
import { useToastr } from "../../toastr.js";
import MyClosePrioListItem from "./MyClosePrioListItem.vue";
import { debounce } from "lodash";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import html2canvas from "html2canvas";
import { ContentLoader } from "vue-content-loader";

const isloading = ref(false);
const toastr = useToastr();
const lists = ref({ data: [] });

const authUserStore = useAuthUserStore();

const getItems = (page = 1) => {
  isloading.value = true;
    axios
        .get(`/api/mycloseprio?page=${page}`, {
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

const capturemycloseprio = () => {
    const container = document.getElementById("capturePrioContainer");

    html2canvas(container).then((canvas) => {
        const dataURL = canvas.toDataURL();
        const link = document.createElement("a");
        link.href = dataURL;
        link.download = "MY CLOSED PRIO.png";
        link.click();
    });
};

const searchQuery = ref(null);

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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">My Closed Prio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card" id="capturePrioContainer">
                <div class="card-header">
                    <div class="card-title">
                        <div class="card-title">
                            <h5>
                                {{
                                    authUserStore.user.first_name +
                                    " " +
                                    authUserStore.user.last_name
                                }}
                                - My Closed Prio
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                        <ContentLoader
                                v-if="isloading"
                                viewBox="0 0 250 110"
                            >
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
                    <div v-else class="content">
                        <div class="container-fluid">

                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <button
                                        @click="capturemycloseprio"
                                        type="button"
                                        class="mb-2 btn btn-sm btn-success"
                                    >
                                        <i class="fa fa-camera"></i>
                                    </button>
                                </div>
                                <div class="d-flex">
                                    <i class="fa fa-filter mr-1"></i>
                                </div>
                            </div>

                            <div>
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-sm table-striped table-hover"
                                    >
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Planned Date</th>
                                                <th>Planned Date End</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Task Type</th>
                                                <th>Project</th>
                                                <th>Status</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="lists.data.length > 0">
                                            <MyClosePrioListItem
                                                v-for="(
                                                    item, index
                                                ) in lists.data"
                                                :key="item.id"
                                                :item="item"
                                                :index="index"
                                            />
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td
                                                    colspan="9"
                                                    class="text-center"
                                                >
                                                    No results found...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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





</template>
