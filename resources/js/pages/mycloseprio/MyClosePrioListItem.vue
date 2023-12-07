<script setup>
import { formatDate } from "../../helper.js";
import { ref } from "vue";
import { useToastr } from "../../toastr.js";
import axios from "axios";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import DOMPurify from 'dompurify';
const toastr = useToastr();
const authUserStore = useAuthUserStore();
const props = defineProps({
    item: Object,
    index: Number,
});

</script>
<template>
    <tr>

        <td>{{ item.taskname}}</td>
        <td>{{ item.plandate }}</td>
        <td>{{ item.planenddate }}</td>
        <td>{{ item.startdate }}</td>
        <td>{{ item.enddate }}</td>
        <td>{{ item.tasktype.listtask }}</td>
        <td>{{ item.tasktype.prodject }}</td>
        <td>{{ item.status }}</td>
        <td>{{ item.remarks }}</td>
    </tr>
</template>

<style scoped>
.custom-link {
  color: black; /* or any other color you prefer */
  text-decoration: none; /* Optional: Remove underline */
}
</style>
