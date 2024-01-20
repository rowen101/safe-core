<script setup>
import { onMounted, ref } from 'vue';
import { useAuthUserStore } from "../stores/AuthUserStore";
import { Bar } from "vue-chartjs"
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

// const chartData ={
//   labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
//   datasets: [
//     {
//       label: "Task",
//       data: [2, 5, 4, 8, 10, 4, 7],
//       backgroundColor: "#1CBAB7",
//     },
//     {
//       label: "Open Todos",
//       data: [2, 5, 4, 8, 10, 4, 7],
//       backgroundColor: "#72CCFF",
//     },
//     {
//       label: "Close Todos",
//       data: [2, 5, 4, 8, 10, 4, 7],
//       backgroundColor: "#008080",
//     },
//   ],
// };

const authUserStore = useAuthUserStore();
const chartData = ref([]);
const totalAppointmentsCount = ref(0);

const getDailytaskGraph = () => {
    axios.get('/api/dailytaskgrap')
    .then((response) => {
        // Update the chartData ref with the received data
      console.log(response.data);

        // Assuming you have a function to update your chart (replace updateChartFunction)
        //updateChartFunction(chartData.value);

      
    }).catch((error) => {
        console.error(error);
    });
};

const selectedDateRange = ref('today');
const totalUsersCount = ref(0);

const getUsersCount = () => {
    axios.get('/api/stats/users', {
        params: {
            date_range: selectedDateRange.value,
        }
    })
    .then((response) => {
        totalUsersCount.value = response.data.totalUsersCount;
    });
};

onMounted(() => {
    getDailytaskGraph();
    getUsersCount();
});
</script>
<template>


    <div class="content">
        <div class="container-fluid">
             <div class="card">
                    <Bar :data="chartData" />
                 </div>
            <div class="row">


                <!-- <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <div class="d-flex justify-content-between">
                                <h3>{{ totalAppointmentsCount }}</h3>
                                <select v-model="selectedAppointmentStatus" @change="getDailytaskGraph()" style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                                    <option value="all">All</option>
                                    <option value="scheduled">Scheduled</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <p>Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <router-link to="/admin/appointments" class="small-box-footer">
                            View Appointments
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div> -->

                <div v-if="authUserStore.user.name == 'admin'" class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <div class="d-flex justify-content-between">
                                <h3>{{ totalUsersCount }}</h3>
                                <select v-model="selectedDateRange" @change="getUsersCount()" style="height: 2rem; outline: 2px solid transparent;" class="px-1 rounded border-0">
                                    <option value="today">Today</option>
                                    <option value="30_days">30 days</option>
                                    <option value="60_days">60 days</option>
                                    <option value="360_days">360 days</option>
                                    <option value="month_to_date">Month to Date</option>
                                    <option value="year_to_date">Year to Date</option>
                                </select>
                            </div>
                            <p>Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <router-link to="/admin/user" class="small-box-footer">
                            View Users
                            <i class="fas fa-arrow-circle-right"></i>
                        </router-link>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
