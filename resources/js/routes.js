import Dashboard from './components/Dashboard.vue';
import ListAppointments from './pages/appointments/ListAppointments.vue';
import AppointmentForm from './pages/appointments/AppointmentForm.vue';
import UserList from './pages/users/UserList.vue';
import UpdateSetting from './pages/settings/UpdateSetting.vue';
import UpdateProfile from './pages/profile/UpdateProfile.vue';
import Login from './pages/auth/Login.vue';
// import Register from './pages/auth/Register.vue';
import ClientList from './pages/client/ClientList.vue';
import TechList from './pages/techrecomm/TechList.vue';
import MyPrio from './pages/myprio/MyPrio.vue';
import MyVsc from './pages/myvsc/MyVsc.vue';
import MyClosedPrio from './pages/mycloseprio/MyClosePrioList.vue';
import UserMenu from './pages/usermenu/UserMenuList.vue';

export default [
    {
        path: '/login',
        name: 'admin.login',
        component: Login,
    },
    // {
    //     path: '/register',
    //     name: 'admin.register',
    //     component: Register,
    // },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },

    {
        path: '/admin/appointments',
        name: 'admin.appointments',
        component: ListAppointments,
    },

    {
        path: '/admin/appointments/create',
        name: 'admin.appointments.create',
        component: AppointmentForm,
    },

    {
        path: '/admin/appointments/:id/edit',
        name: 'admin.appointments.edit',
        component: AppointmentForm,
    },

    {
        path: '/admin/user',
        name: 'admin.users',
        component: UserList,
    },

    {
        path: '/admin/settings',
        name: 'admin.settings',
        component: UpdateSetting,
    },

    {
        path: '/admin/profile',
        name: 'admin.profile',
        component: UpdateProfile,
    },

    {
        path: '/admin/client',
        name: 'admin.client',
        component: ClientList,
    },

    {
        path: '/admin/tech-recommendation',
        name: 'admin.tech',
        component: TechList,
    },
    {
        path: '/admin/weekly-task-schedule/myprio',
        name: 'My Prio',
        component: MyPrio,
    },

    {
        path: '/admin/weekly-task-schedule/my-closed-prio',
        name: 'My Closed Prio',
        component: MyClosedPrio,
    },
    {
        path: '/admin/weekly-task-schedule/myvsc',
        name: 'My VSC',
        component: MyVsc,
    },
    {
        path: '/admin/usermenu',
        name: 'User Menu',
        component: UserMenu,
    }

]
