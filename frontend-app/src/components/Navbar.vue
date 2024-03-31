<template lang="">
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <router-link class="navbar-brand" to="/">TODO</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <router-link class="nav-link active" aria-current="page" to="/">Home</router-link>
                    </li>
                    <li class="nav-item" v-if="user">
                    <router-link class="nav-link" to="/todos">Todos</router-link>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                    </li>
                </ul>
                </div>
            </div>
            <div class="users">
                <!-- <span v-if="userEmail">  {{userEmail}}</span> -->
                <div class="dropdown" v-if="user">
                    <span type="button" class=" dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="../assets/user-2.png" alt="user">
                        <span class="user">{{user}}</span>

                    </span>
                    <ul class="dropdown-menu">
                        
                        <li  class="mb-3"><img src="../assets/profile.png" alt="user"></li>
                        <li>{{user}}</li>
                        <!-- <li><hr class="dropdown-divider"></li> -->
                        <hr class="dropdown-divider">
                        <li><router-link to='/userManagement' style="color:black;">Settings</router-link></li>
                        <hr class="dropdown-divider">
                        <li @click="logout" style="cursor:pointer;" class='logout py-2 px-5'><img src="../assets/logout.png" alt=""> Logout</li>
                    </ul>
                </div>
                <span v-else>
                    <router-link to='/login' class='link'>     Login / </router-link> 
                    <router-link to='/register' class='link'>Signup</router-link>
                </span>
                <div class='addTask'>
                    <button class="login_btn" @click="showDialogue = true" v-if="user" :style="{display:user?'block':'none'}">Add task</button>
                <router-link to='/login'  v-if="!user"><button class="login_btn" :style="{display:!user?'block':'none'}">Add task</button></router-link>
                </div>
            </div>
            <AddTask :show="showDialogue" title="Are you sure" :cancel="cancel"  @add-task="handleAddTask" />
        </nav>
    </div>
</template>
<script>
import AddTask from "./AddTask.vue"
export default {
    name: 'NavbarHeader',
    components: {
        AddTask
    },
    data() {
        return {
            user: '',
            todo: JSON.parse(localStorage.getItem('Todos')) || [],
            showDialogue: false
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            const userInfoString = localStorage.getItem('userData')
            const userInfo = JSON.parse(userInfoString);
            console.log("userInfo", userInfo)
            this.user = userInfo.name;
            console.log(this.user);
        },

        handleAddTask(newTask) {
            const newTodos = [...this.todo, newTask];
            this.todo = newTodos;
            localStorage.setItem("Todos", JSON.stringify(newTodos));
            this.showDialogue = false;
            window.location.reload();

        },

        cancel() {
            this.showDialogue = false
        },


        logout() {
            // clear the token and redirect to login page
            localStorage.removeItem("userData");
            window.location = '/';
        }
    }
}
</script>

<style scoped>
.addTask .login_btn {
    position: absolute;
    top: -13px;
    margin-left: 23px;
    padding: 8px 24px;
    background-color: #c5f1f0;
    color: #117e91ad;
}

.navbar.navbar-expand-lg {
    z-index: 1;
    margin-top: -60px;
    background-color: #29b5ad;
}

.container-fluid {
    width: 70%;

}

.navbar-brand {
    font-family: "Roboto", sans-serif;
    font-size: 2rem;
    font-weight: 800;
}

.navbar-expand-lg .navbar-collapse {
    margin-left: 80px;
    font-size: 18px;
}

.users {
    display: flex;
    position: relative;
    right: 80px;
    width: 250px;
    color: white;
}


.users span {
    opacity: 0.8;
}

.users span .link {
    color: white;
    text-decoration: none;
}

.dropdown .dropdown-menu {
    padding: 15px;
    width: 250px;
    padding-bottom: 5px;
    text-align: center;
}

.logout:hover {
    transition: 0.4s ease;
    background-color: #eeee;

}

@media(max-width:1000px) {
    .dropdown {
        position: absolute;
        right: 110px;
        top: -40px;
    }

    .dropdown .dropdown-toggle .user {
        display: none;
    }

    .container-fluid {
        width: 100% !important;
    }

    .navbar-dark .navbar-brand {
        margin: auto;
    }

    .addTask .login_btn {
        position: fixed;
        top: 84%;
        right: 7%;
        border-radius: 100%;
        content-visibility: hidden;
        background-image: url("../assets/plus.png");
        background-repeat: no-repeat;
        background-position: center;
        padding: 25px 25px;

    }
}
</style>