<script setup>
import { onMounted, ref, watch } from "vue";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import moment from "moment";
import ListItem from "./ListItem.vue";
import html2canvas from "html2canvas";
import { ContentLoader } from "vue-content-loader";
import Datepicker from 'vue3-datepicker'
const authUserStore = useAuthUserStore();





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


// Create a reactive form object


const form = ref({
  start_date: '',
  end_date: ''
});

const fromDate = ref('');
const toDate = ref('');

// Watch for changes in Sdate and StrHours and update plandate
watch([fromDate], () => {
  const originalDate = new Date(fromDate.value);
  const year = originalDate.getFullYear();
  const month = String(originalDate.getMonth() + 1).padStart(2, '0');
  const day = String(originalDate.getDate()).padStart(2, '0');
  form.value.start_date = `${year}-${month}-${day}`;
});

// Watch for changes in Edate and EndHours and update planenddate
watch([toDate], () => {
  const originalDate = new Date(toDate.value);
  const year = originalDate.getFullYear();
  const month = String(originalDate.getMonth() + 1).padStart(2, '0');
  const day = String(originalDate.getDate()).padStart(2, '0');
  form.value.end_date = `${year}-${month}-${day}`;
});

const applyFilter = () => {
//   alert(`${form.value.start_date} ${form.value.end_date}`);


  isloading.value = true;


  axios.get('/api/filter-vsc', {
    start_date: form.value.start_date,
    end_date: form.value.end_date
  })
    .then(response => {
      isloading.value = false;
      lists.value = response.data.dailyTasks;
      listscount.value = response.data.TaskList;
      console.log(response.data);
    })
    .catch(error => {
      // Handle errors
      console.error(error);
    })
    .finally(() => {
      // Close the modal or perform any other actions
      $('#FormModalfilterDate').modal('hide');
    });
};

onMounted(() => {
    getItems();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">

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


<!-- <div :class="'small-box ' +
        (moment(task.taskdate).format(
            'MMMM D, YYYY'
        ) === formattedDate
            ? 'bg-primary'
            : 'bg-info')
        ">
        <br>
        <div class="calendar">
            15<em>March</em>
        </div>
    </div> -->
                                        <div :class="'small-box ' +
                                            (moment(task.taskdate).format(
                                                'MMMM D, YYYY'
                                            ) === formattedDate
                                                ? 'bg-primary'
                                                : 'bg-info')
                                            ">
                                            <div class="inner">
                                                <div class="card text-center text-dark">
                                                    <p class="mt-1">
                                                        {{
                                                            moment(
                                                                task.taskdate
                                                            ).format("dddd")
                                                        }}
                                                        <i class="far fa-calendar-alt"></i><br>
                                                         {{
                                                        moment(
                                                            task.taskdate
                                                        ).format("MMMM D, YYYY")
                                                    }}<br>

                                                    </p>
                                                    <div class="border text-bold">  {{
                                                       task.site_name
                                                    }}</div>
                                                </div>



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
                                <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">

                                    <thead>
                                        <tr>
                                            <th>Planed Date</th>
                                            <th>Total Task</th>
                                            <th>Complete</th>
                                            <th>Status</th>
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
                    <div class="fromtocenter">
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

<style scoped>
    .fromtocenter {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        /* Optional: Add additional styling if needed */
        margin-top: 5px; /* Adjust as needed */
    }


    /*
calendar css
Ref: http://codepen.io/chelovekov/pen/ayKAn
*/

.calendar {
margin:.25em 10px 10px 0;
padding-top:5px;
float:left;
width:200px;
background:#ededef;
background:-webkit-gradient(linear,left top,left bottom,from(#ededef),to(#ccc));
background:-moz-linear-gradient(top,#ededef,#ccc);
font:bold 30px/60px Arial Black,Arial,Helvetica,sans-serif;
text-align:center;
color:#000;
text-shadow:#fff 0 1px 0;
-moz-border-radius:3px;
-webkit-border-radius:3px;
border-radius:3px;
position:relative;
-moz-box-shadow:0 2px 2px #888;
-webkit-box-shadow:0 2px 2px #888;
box-shadow:0 2px 2px #888
}

.calendar em {
display:block;
font:normal bold 11px/30px Arial,Helvetica,sans-serif;
color:#fff;
text-shadow:#00365a 0 -1px 0;
background:#04599a;
background:-webkit-gradient(linear,left top,left bottom,from(#04599a),to(#00365a));
background:-moz-linear-gradient(top,#04599a,#00365a);
-moz-border-radius-bottomright:3px;
-webkit-border-bottom-right-radius:3px;
border-bottom-right-radius:3px;
-moz-border-radius-bottomleft:3px;
-webkit-border-bottom-left-radius:3px;
border-bottom-left-radius:3px;
border-top:1px solid #00365a
}

.calendar:before,.calendar:after {
content:'';
float:left;
position:absolute;
top:5px;
width:8px;
height:8px;
background:#111;
z-index:1;
-moz-border-radius:10px;
-webkit-border-radius:10px;
border-radius:10px;
-moz-box-shadow:0 1px 1px #fff;
-webkit-box-shadow:0 1px 1px #fff;
box-shadow:0 1px 1px #fff
}

.calendar:before {
left:11px
}

.calendar:after {
right:11px
}

.calendar em:before,.calendar em:after {
content:'';
float:left;
position:absolute;
top:-5px;
width:4px;
height:14px;
background:#dadada;
background:-webkit-gradient(linear,left top,left bottom,from(#f1f1f1),to(#aaa));
background:-moz-linear-gradient(top,#f1f1f1,#aaa);
z-index:2;
-moz-border-radius:2px;
-webkit-border-radius:2px;
border-radius:2px
}

.calendar em:before {
left:13px
}

.calendar em:after {
right:13px
}
</style>
