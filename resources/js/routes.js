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
import Menu from './pages/menu/MenuList.vue';
import ErrorLayout from './404.vue';
import Notifications from './pages/notification/index.vue';


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
        path: '/sli/dashboard/',
        name: 'Dashboard',
        component: Dashboard,

    },
    {
        path: '/sli/appointments/create',
        name: 'Appointments',
        component: AppointmentForm,
    },

    {
        path: '/sli/appointments/:id/edit',
        name: 'Appointments',
        component: AppointmentForm,
    },

    {
        path: '/sli/user',
        name: 'User',
        component: UserList,
    },

    {
        path: '/sli/settings',
        name: 'Setting',
        component: UpdateSetting,
    },

    {
        path: '/sli/profile',
        name: 'Profile',
        component: UpdateProfile,
    },

    {
        path: '/sli/client',
        name: 'Client',
        component: ClientList,
    },

    {
        path: '/sli/tech-recommendation',
        name: 'Tech Recomm',
        component: TechList,
    },
    {
        path: '/sli/weekly-task-schedule/myprio',
        name: 'My Prio',
        component: MyPrio,
    },

    {
        path: '/sli/weekly-task-schedule/my-closed-prio',
        name: 'My Closed Prio',
        component: MyClosedPrio,
    },
    {
        path: '/sli/weekly-task-schedule/myvsc',
        name: 'My VSC',
        component: MyVsc,
    },
    {
        path: '/sli/usermenu',
        name: 'User Menu',
        component: UserMenu,
    },
    {
        path: '/sli/menu',
        name: 'Menu',
        component: Menu,
    },
    {
        path: '/sli/notifications',
        name: 'Notifications',
        component: Notifications, // Replace with your actual 404 component
    },

    {
        path: '/sli/appointments',
        name: 'Appointments',
        component: ListAppointments,
    },

 


  //////////////////////////////////////////////
  //
  //    admin routes
  //
  //////////////////////////////////////////////


   // Add the following 404 route at the end
   {
    path: '/:catchAll(.*)',
    name: '404 Error Page',
    component: ErrorLayout, // Replace with your actual 404 component
},

]
