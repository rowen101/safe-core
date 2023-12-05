<script setup>
import { onMounted, ref } from "vue";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import moment from 'moment';
import ListItem from "./ListItem.vue";
import html2canvas from 'html2canvas';

const authUserStore = useAuthUserStore();

//format date
const getFormattedDate = () => {
    const options = { month: "long", day: "numeric", year: "numeric" };
    return new Date().toLocaleString("en-US", options);
};
const formattedDate = ref(getFormattedDate());
//end format date

  const isCurrentDate = (taskDate) => {
      const currentDate = new Date().toISOString().split('T')[0];
      return taskDate === currentDate;
    };

//capture function
const capturevsc = () =>{
     const container = document.getElementById('captureVSCContainer');

            html2canvas(container).then((canvas) => {
                const dataURL = canvas.toDataURL();
                const link = document.createElement('a');
                link.href = dataURL;
                link.download = 'My VSC.png';
                link.click();
            });

}

const capturehitrate = () =>{
     const container = document.getElementById('captureHitRateContainer');

            html2canvas(container).then((canvas) => {
                const dataURL = canvas.toDataURL();
                const link = document.createElement('a');
                link.href = dataURL;
                link.download = 'My HITRATE.png';
                link.click();
            });

}

const containercapture = ref(null);
const selectedDateRange = ref("today");
const lists = ref({ data: [] });

const getItems = () => {
    axios
        .get(`/api/myvsc`)
        .then((response) => {
            lists.value = response.data;

        });
};

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
                                        <button
                                            @click="capturevsc"
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
                                <div class="row" >
                                    <div class="col-lg-3 col-6" v-for="task in lists"
                                    :key="task.id"
                                    >
                                        <!-- <div class="small-box bg-info"> -->
                                      <div :class="'small-box ' + (moment(task.taskdate).format('MMMM D, YYYY') === formattedDate ? 'bg-primary' : 'bg-info')">


                                            <div class="inner">
                                                <div class="card text-center text-dark">
                                                    <h5 class="mt-1">
                                                              {{moment(task.taskdate).format('dddd')}}
                                                        <i
                                                            class="far fa-calendar-alt"
                                                        ></i>
                                                    </h5>
                                                </div>
                                                <div class="card text-center text-dark">

                                                    {{moment(task.taskdate).format('MMMM D, YYYY')}}
                                                </div>

                                                <hr class="bg-white" />
                                                <div
                                                    class="d-flex justify-content-between"
                                                >
                                                    <div class="d-flex mr-2">
                                                        <span class="badge">VSC</span>
                                                    </div>
                                                    <div class="d-flex">
                                                        <p
                                                            style="
                                                                font-size: 15px;
                                                                text-align: left;
                                                            "
                                                        >
                                                            {{task.site}}
                                                        </p>
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

                                        <button
                                            @click="capturehitrate"
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
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Planed Date</th>
                                            <th>Total Task</th>
                                            <th>Complete</th>
                                            <th>Remarks</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <ListItem
                                            v-for="item in lists"
                                            :key="item.id"
                                            :item="item"
                                        />
                                     </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


