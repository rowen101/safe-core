<template>
    <div class="container">
        <div class="header">
            <img
                class="logo"
                :src="'/img/IT_Technical_Recommendation .jpg'"
                alt="Right Logo"
            />

            <img class="logo" :src="'/img/safexpress.jpeg'" alt="Left Logo" />
        </div>
        <div class="header">
            <span>Recommendation No: <strong>TECH001</strong></span>
            <span>Date Checked: <strong>Feb 29, 2024</strong></span>
        </div>
        <div class="header-justify-space-between">
            <div>
                <span>Company: <strong>Safexpress Logistics Inc.</strong></span
                ><br />
                <span>Branch: <strong>JSU-CEBU</strong></span>
            </div>

            <p></p>
            <div>
                <span>Warehouse: <strong></strong></span><br />
                <span>User: <strong>Rene</strong></span>
            </div>

            <p></p>
        </div>

        <strong>Unit details</strong>
        <div class="content">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam
                ac ante vel nisi interdum fermentum sit amet vitae nulla. Mauris
                pharetra libero eu purus blandit, nec malesuada turpis auctor.
            </p>
        </div>
        <strong>Reported problem</strong>
        <div class="content">
            <p>
                Donec euismod eros eu sapien tristique, vitae efficitur nunc
                blandit. In hac habitasse platea dictumst. Phasellus fermentum,
                eros id auctor ultrices, elit libero elementum eros, a eleifend
                mauris lacus vel est.
            </p>
        </div>

        <strong>Assessment conducted</strong>
        <div class="content">
            <p>
                Donec euismod eros eu sapien tristique, vitae efficitur nunc
                blandit. In hac habitasse platea dictumst. Phasellus fermentum,
                eros id auctor ultrices, elit libero elementum eros, a eleifend
                mauris lacus vel est.
            </p>
        </div>

        <strong>Recommendation</strong>
        <div class="content">
            <p>
                Donec euismod eros eu sapien tristique, vitae efficitur nunc
                blandit. In hac habitasse platea dictumst. Phasellus fermentum,
                eros id auctor ultrices, elit libero elementum eros, a eleifend
                mauris lacus vel est. <br>
                  Donec euismod eros eu sapien tristique, vitae efficitur nunc
                blandit. In hac habitasse platea dictumst. Phasellus fermentum,
                eros id auctor ultrices, elit libero elementum eros, a eleifend
                mauris lacus vel est.
            </p>
        </div>
        <div class="header">
            <div>
                <strong>Evaluated by:</strong><br />
                <span class="botoom-line">Rowen Gonzales</span><br />
                <span>IT Corporate</span>
                <span></span>
            </div>

            <p></p>
            <div>
                <strong>Noted by:</strong><br />
                <span class="botoom-line">Rowen Gonzales</span><br />
                <span>IT Corporate</span><br />
            </div>

            <p></p>
        </div>


        <span>Approved by:(2/29/2024 4:51:58 PM)</span>
    </div>
</template>
<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRoute } from 'vue-router';

const pageTitle = `${useRoute().params.id}`;

const getechrecom =()=>{
    axios.get(`/api/techApproved/${route.params.id}`)
    .then((response) => {
        console.log(response.data);
    })
    .catch((error) => {
        actions.setErrors(error.response.data.errors);
    })
}
onMounted(() => {
    document.title = pageTitle;
});
</script>

<style scoped>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
}
.header,
.header-justify-space-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.header-justify-space-between {
    margin-bottom: 10px;
    align-items: left;
}
.logo {
    width: 260px; /* Adjust size as needed */
    height: auto;
}
.botoom-line {
    border-bottom: 1px solid #757575;
}
.content {
    line-height: 1.6;
    border: 2px solid #757575;
    margin-bottom: 20px;

}
.signature {
    margin-top: 40px;
}
</style>
