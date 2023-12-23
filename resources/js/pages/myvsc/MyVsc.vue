<script setup>
import { onMounted, ref } from "vue";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import moment from "moment";
import ListItem from "./listitem.vue";
import html2canvas from "html2canvas";
import { ContentLoader } from "vue-content-loader";
import Datepicker from 'vue3-datepicker'
const authUserStore = useAuthUserStore();


const fromDate = ref('');
const toDate = ref('');
const isloading = ref(false);
//format date
const getFormattedDate = () => {
    const options = { month: "long", day: "numeric", year: "numeric" };
    return new Date().toLocaleString("en-US", options);
};
const formattedDate = ref(getFormattedDate());
//end format date

const isCurrentDate = (taskDate) => {
    const currentDate = new Date().toISOString().split("T")[0];
    return taskDate === currentDate;
};

//capture function
const capturevsc = () => {
    const container = document.getElementById("captureVSCContainer");

    html2canvas(container).then((canvas) => {
        const dataURL = canvas.toDataURL();
        const link = document.createElement("a");
        link.href = dataURL;
        link.download = "My VSC.png";
        link.click();
    });
};

const capturehitrate = () => {
    const container = document.getElementById("captureHitRateContainer");

    html2canvas(container).then((canvas) => {
        const dataURL = canvas.toDataURL();
        const link = document.createElement("a");
        link.href = dataURL;
        link.download = "My HITRATE.png";
        link.click();
    });
};

const containercapture = ref(null);
const selectedDateRange = ref("today");
const lists = ref({ data: [] });
const listscount = ref({ data: [] });
const getItems = () => {
    isloading.value = true;
    axios.get(`/api/myvsc`).then((response) => {
        isloading.value = false;
        lists.value = response.data.dailyTasks;
        listscount.value = response.data.TaskList;
    });
};

const onFilterDate = () => {
    $("#FormModalfilterDate").modal("show");
}

onMounted(() => {
    getItems();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2"></div>
            <div class="col-12">
                <div class="card" id="captureVSCContainer">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>
                                {{
                                    authUserStore.user.first_name +
                                    " " +
                                    authUserStore.user.last_name
                                }}
                                - My VSC
                            </h5>
                        </div>

                        <div class="card-tools">
                            {{ formattedDate }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="content">
                            <div class="container-fluid">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <button @click="capturevsc" type="button" class="mb-2 btn btn-sm btn-success">
                                            <i class="fa fa-camera"></i>
                                        </button>
                                    </div>
                                    <div class="d-flex">
                                        <i class="fa fa-filter mr-1" @click="onFilterDate"></i>
                                    </div>
                                </div>
                                <ContentLoader v-if="isloading" viewBox="0 0 250 110">
                                    <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                                    <rect x="0" y="20" rx="3" ry="3" width="250" height="10" />
                                    <rect x="0" y="40" rx="3" ry="3" width="250" height="10" />
                                    <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                                </ContentLoader>
                                <div v-else class="row">
                                    <div class="col-lg-3 col-6" v-for="task in lists" :key="task.id">
                                        <!-- <div class="small-box bg-info"> -->
                                        <div :class="'small-box ' +
                                            (moment(task.taskdate).format(
                                                'MMMM D, YYYY'
                                            ) === formattedDate
                                                ? 'bg-primary'
                                                : 'bg-info')
                                            ">
                                            <div class="inner">
                                                <div class="card text-center text-dark">
                                                    <h5 class="mt-1">
                                                        {{
                                                            moment(
                                                                task.taskdate
                                                            ).format("dddd")
                                                        }}
                                                        <i class="far fa-calendar-alt"></i>
                                                    </h5>
                                                </div>
                                                <div class="card text-center text-dark">
                                                    {{
                                                        moment(
                                                            task.taskdate
                                                        ).format("MMMM D, YYYY")
                                                    }}
                                                </div>

                                                <hr class="bg-white" />
                                                <div>
                                                    <div v-if="task.task_lists &&
                                                            task.task_lists
                                                                .length > 0
                                                            ">
                                                        <span class="badge">task</span>
                                                        <ul class="list-group text-dark">
                                                            <li class="list-group-item" v-for="taskList in task.task_lists"
                                                                :key="taskList.id
                                                                    ">
                                                                <i :class="taskList.iscompleted ==
                                                                        1
                                                                        ? 'fa fa-check-circle'
                                                                        : 'fa fa-circle'
                                                                    " style="
                                                                            font-size: 15px;
                                                                        "></i>
                                                                &nbsp;{{
                                                                    taskList.task_name
                                                                }}
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <span v-else class="text-center">No task</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hit rate -->
                <div id="captureHitRateContainer" class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>
                                {{
                                    authUserStore.user.first_name +
                                    " " +
                                    authUserStore.user.last_name
                                }}
                                - My HIT RATE
                            </h5>
                        </div>

                        <div class="card-tools">
                            {{ formattedDate }}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="content">
                            <div class="container-fluid">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <button @click="capturehitrate" type="button" class="mb-2 btn btn-sm btn-success">
                                            <i class="fa fa-camera"></i>
                                        </button>
                                    </div>

                                </div>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Planed Date</th>
                                            <th>Total Task</th>
                                            <th>Complete</th>
                                            <th>Reason</th>
                                            <th>Remarks</th>
                                            <th>Percentage Task</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <ListItem v-for="item in listscount" :key="item.id" :item="item" />
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="FormModalfilterDate" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span>My VSC Summary Report</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class=" d-flex justify-content-center align-items-center card border-0">
                        <div>
                            <label for="fromDate">From:</label>
                            <datepicker v-model="fromDate"></datepicker>
                        </div>

                        <div>
                            <label for="toDate">To:</label>
                            <datepicker v-model="toDate"></datepicker>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button @click="applyFilter" type="button" class="btn btn-primary">
                        Generate
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

