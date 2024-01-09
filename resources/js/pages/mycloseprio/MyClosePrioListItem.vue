<script setup>
import { formatDate } from "../../helper.js";
import { ref } from "vue";
import { useToastr } from "../../toastr.js";
import axios from "axios";
import { useAuthUserStore } from "../../stores/AuthUserStore";
import DOMPurify from 'dompurify';
import moment from 'moment';
const toastr = useToastr();
const authUserStore = useAuthUserStore();
const props = defineProps({
    item: Object,
    index: Number,
});

</script>
<template>
    <tr>
         <td>{{ index + 1 }}</td>
        <td>{{moment(item.taskdate).format('MMMM D, YYYY')}}</td>
        <td>{{ item.startdate }}</td>
        <td>{{ item.enddate }}</td>
        <td>{{ item.tasktype.listtask }}</td>
        <td>{{ item.status }}</td>
        <td class="text-center"><span :class="[ 'badge', item.remarks === 'HIT' ? 'bg-primary' : 'bg-danger' ]">
    {{ item.remarks }}</span></td>

    </tr>
</template>

<style scoped>
.custom-link {
  color: black; /* or any other color you prefer */
  text-decoration: none; /* Optional: Remove underline */
}
</style>
