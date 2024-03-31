<template>
    <div class="container">
        <h3>My Todo List</h3>
        <div class="todosDetail">
            <div :class="[item?.completed ? 'completed' : '', 'todo']" :key="item?.id" v-for="item in todo[0]"
                @dblclick="ontoggle(item?.id)">
                <h5>
                    {{ item.todo }}
                    <i class="fas fa-times" @click="onDelete(item.id)"></i>
                </h5>
                <p>{{ item.description }}</p>
                <p>
                    {{ item.day }}
                    <i class="fa-regular fa-pen-to-square" @click="editTodo(item?.id)"></i>
                </p>
            </div>
        </div>
        <button class="login_btn" @click="showDialogue = true">Add task</button>
        <AddTask v-if="showDialogue" :show="showDialogue" :cancel="cancel" :edit-mode="editMode" :edit-task="editTask"
            @add-task="handleAddTask" />
    </div>
</template>
  
<script>
import AddTask from "./AddTask.vue";

export default {
    name: "TaskPage",
    components: {
        AddTask,
    },
    data() {
        return {
            todo: [],
            showDialogue: false,
            editMode: false,
            editTask: null,
        };
    },
    created() {
        this.fetchTodo();
    },
    methods: {
        fetchTodo() {
            // const todoString = localStorage.getItem("Todos");
            // if (todoString) {
            //     // this.todo = this.todo.filter(item => item.todo && item.day && item.completed !== undefined)

            //     this.todo = [JSON.parse(todoString)];
            // }

            const userInfoString = localStorage.getItem('userData')
            const userInfo = JSON.parse(userInfoString);
            let userId = userInfo.user_id;
            const todoString = localStorage.getItem("Todos");
            if (todoString) {
                const todoData = JSON.parse(todoString);
                // Filter todo items based on user_id
                this.todo = [todoData.filter(item => item.user_id === userId)];
            }
        },
        handleAddTask(newTask) {
            const todoString = localStorage.getItem("Todos");
            const todoData = JSON.parse(todoString) || [];
            if (this.editMode) {
                const index = todoData.findIndex((task) => task.id === this.editTask.id);
                todoData[index] = newTask;
                localStorage.setItem("Todos", JSON.stringify(todoData));
                this.editMode = false;
                this.editTask = null;
                this.fetchTodo();

            } else {
                // this.todo[0].push(newTask);
                // localStorage.setItem("Todos", JSON.stringify(this.todo[0]));
                // console.log(this.todo[0]);
                todoData.push(newTask);
            }
            localStorage.setItem("Todos", JSON.stringify(todoData));

            this.fetchTodo();
            this.showDialogue = false;
        },
        onDelete(id) {
            if (confirm('Are you sure?')) {
                const todoString = localStorage.getItem("Todos");
                let todoData = JSON.parse(todoString) || [];
                todoData = todoData.filter((item) => item.id !== id);
                localStorage.setItem("Todos", JSON.stringify(todoData));
                this.fetchTodo();
            }
        },
        ontoggle(id) {
            const todoString = localStorage.getItem("Todos");
            let todoData = JSON.parse(todoString) || [];
            const index = todoData.findIndex((task) => task.id === id);
            todoData[index].completed = !todoData[index].completed;
            localStorage.setItem("Todos", JSON.stringify(todoData));
            this.fetchTodo();
        },
        editTodo(id) {
            const todoString = localStorage.getItem("Todos");
            let todoData = JSON.parse(todoString) || [];
            this.editTask = todoData.find((task) => task.id === id);
            this.editMode = true;
            this.showDialogue = true;
        },
        cancel() {
            this.editMode = false;
            this.editTask = null;
            this.showDialogue = false;
        },
    },
};
</script>
  
<style scoped>
.container {
    margin: 0 auto;
}

.todosDetail {
    max-height: 650px;
    overflow-y: auto;
    scrollbar-width: thin;
}

.todo {
    background: #f4f4f4;
    margin: 5px;
    padding: 10px 20px;
    cursor: pointer;
}

.todo.completed {
    border-left: 8px solid #29b5ad;
}

.todo p,
.todo h5 {
    text-align: left;
    margin-bottom: 5px
}

.todo h5 .fas {
    color: red;
    float: right;
}

.todo .fa-regular {
    color: green;
    opacity: 0.7;
    float: right;
}

.todo h4 .fas:hover {
    border-radius: 100%;
    /* padding: 10px; */
    background-color: #dadada;
}
</style> 