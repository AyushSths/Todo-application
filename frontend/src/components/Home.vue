<template>
  <div class="hello">
    <div class="bg_image"></div>
    <div class="slogan" style="position: relative;">
      <div class="msg">
        <h1><b>The Power of <span class="todo" style="color: #26a7a0;">Todo
              List</span></b></h1>
        <p>Take control of your day, take control of your life with a to-do list.</p>
      </div>
      <div v-if="user">
        <router-link to="/" style="margin-right:15px" class="login_btn" @click="showDialogue = true">Add
          task</router-link>
        <router-link to="/todos" class="register_btn">My Todo list</router-link>
      </div>
      <div v-show="homePage" v-else>
        <router-link to="/login" style="margin-right:15px" class="login_btn">Join now</router-link>
        <router-link to="/register" class="register_btn">Sign up</router-link>
      </div>
    </div>
    <AddTask :show="showDialogue" title="Are you sure" :cancel="cancel" @add-task="handleAddTask" />
  </div>
</template>

<script>
import AddTask from "./AddTask.vue"
export default {
  name: 'HomePage',
  components: {
    AddTask
  },
  computed: {
    homePage() {
      if (this.$route.path === "/home") {
        return false
      }
      else
        return true
    }
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
      this.user = localStorage.getItem('userData')
      console.log(this.user);
      // this.todo = JSON.parse(localStorage.getItem('todos')) || []
    },

    logout() {
      // clear the token and redirect to login page
      localStorage.removeItem("userData");
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
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.hello {
  background-image: url('~@/assets/wavy_background_2.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  min-height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.bg_image {
  backdrop-filter: blur(8px);
  bottom: 0;
  content: "";
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
}

.msg {
  color: #fff;
  position: relative;
  top: -20px;
}

.msg h1 {
  font-family: "Archivo", sans-serif;
  /* width: 80%; */
  display: inline-flex;
  word-spacing: 5px;
  letter-spacing: 2px;
  font-size: 3.5rem;
  font-weight: 700;
}

router-link {
  text-decoration: none;
}

h3 {
  margin: 40px 0 0;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}

.login_btn {
  display: inline-block;
  padding: 12px 24px;
  text-decoration: none;
  border: 1px solid #fefefe;
  border-radius: 4px;
  transition: all 0.2s ease-in;
  position: relative;
  overflow: hidden;
  font-size: 19px;
  cursor: pointer;
  color: #fff;
  background-color: #29b5ad;
  z-index: 1;
}

.login_btn:before {
  content: "";
  position: absolute;
  left: 50%;
  transform: translateX(-50%) scaleY(1) scaleX(1.25);
  top: 100%;
  width: 140%;
  height: 180%;
  background-color: rgba(0, 0, 0, 0.05);
  border-radius: 50%;
  display: block;
  transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
  z-index: -1;
}

.login_btn:after {
  content: "";
  position: absolute;
  left: 55%;
  transform: translateX(-50%) scaleY(1) scaleX(1.45);
  top: 180%;
  width: 160%;
  height: 190%;
  background-color: #39bda7;
  border-radius: 50%;
  display: block;
  transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
  z-index: -1;
}

.login_btn:hover {
  color: #ffffff;
  border: 1px solid #39bda7;
}

.login_btn:hover:before {
  top: -35%;
  background-color: #39bda7;
  transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
}

.login_btn:hover:after {
  top: -45%;
  background-color: #39bda7;
  transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
}


.register_btn {
  display: inline-block;
  padding: 12px 24px;
  border: 1px solid #fefefe;
  text-decoration: none;
  border-radius: 4px;
  transition: all 0.2s ease-in;
  position: relative;
  overflow: hidden;
  font-size: 19px;
  cursor: pointer;
  color: #fff;
  z-index: 1;
}

.register_btn:before {
  content: "";
  position: absolute;
  left: 50%;
  transform: translateX(-50%) scaleY(1) scaleX(1.25);
  top: 100%;
  width: 140%;
  height: 180%;
  background-color: rgba(0, 0, 0, 0.05);
  border-radius: 50%;
  display: block;
  transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
  z-index: -1;
}

.register_btn:after {
  content: "";
  position: absolute;
  left: 55%;
  transform: translateX(-50%) scaleY(1) scaleX(1.45);
  top: 180%;
  width: 160%;
  height: 190%;
  background-color: #39bda7;
  border-radius: 50%;
  display: block;
  transition: all 0.5s 0.1s cubic-bezier(0.55, 0, 0.1, 1);
  z-index: -1;
}

.register_btn:hover {
  color: #ffffff;
  border: 1px solid #39bda7;
}

.register_btn:hover:before {
  top: -35%;
  background-color: #39bda7;
  transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
}

.register_btn:hover:after {
  top: -45%;
  background-color: #39bda7;
  transform: translateX(-50%) scaleY(1.3) scaleX(0.8);
}
</style>
