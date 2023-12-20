<script setup>
import { formatDate } from "../../helper.js";
import { ref } from "vue";
import { useToastr } from "../../toastr.js";
import axios from "axios";
import moment from 'moment';
import { useAuthUserStore } from "../../stores/AuthUserStore";
import DOMPurify from 'dompurify';
const toastr = useToastr();
const authUserStore = useAuthUserStore();
const props = defineProps({
    item: Object,
    index: Number,
    selectAll: Boolean,
});

// const emit = defineEmits(["showItem"]);

// const toggleSelection = () => {
//     emit("toggleSelection", props.item);
// };




</script>
<template>
    <tr>
        <td>{{moment(item.taskdate).format('MMMM D, YYYY')}}</td>
        <td class="text-center">{{ item.task_lists_count }}</td>
        <td>{{ item.completed_task_count }}</td>
        <td class="text-center"><span v-if="item.status !== 'On Going'">{{  item.status }}</span></td>
        <td v-if="item.remarks === 'HIT'" class="bg-primary text-center">{{ item.remarks }}</td>
         <td v-if="item.remarks === 'MISS'" class="bg-danger text-center">{{ item.remarks }}</td>

         <td :class="{
  'bg-danger': item.percentage_completed >= 0 && item.percentage_completed <= 50,
  'bg-orange': item.percentage_completed > 50 && item.percentage_completed <= 90,
  'bg-success': item.percentage_completed === 100,
  'text-center': true
}">
  {{ item.percentage_completed}} %
</td>
         <td v-if="item.percentage_completed ===50" class="bg-orange text-center">{{ item.percentage_completed}}</td>

        <!-- <td :class="{ 'text-center': true, 'bg-success': item.status === 'HIT', 'bg-danger': item.status !== 'HIT' && item.status !== '' }">{{ item.status }}</td> -->


        <!-- <td>
            <span class="badge" :class="`badge-${item.status.color}`" >{{
                item.status.name
            }} </span>

            &nbsp;<span v-if="item.status.name === 'APPROVED'" class="badge" :class="`badge-${item.status.color}`" v-html="getStatusHtml(item.status)"></span>

        </td> -->


    </tr>
</template>

