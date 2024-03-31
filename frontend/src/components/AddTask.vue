<!-- <template>
    <div v-show="show" class="overlay">


        <div class="dialog">

            <form ref="addTaskForm" @submit="onSubmit">
                <div class="dialog__content">
                    <table>
                        <tr>
                            <td class="title">
                                <input type="text" placeholder="Task name" v-model="todo" :name='this.todo' required />
                            </td>
                        </tr>
                        <tr>
                            <td class="desc"> <input type="text" placeholder="Description" v-model="description" />
                            </td>
                        </tr>
                        <tr>
                            <td class="day"> <input type="date" v-model="day" style="opacity:0.5 ;"></td>
                        </tr>
                        <tr>
                            <td>Set reminder </td>
                            <td><input type="checkbox" v-model="completed"></td>
                        </tr>
                    </table>
                </div>

                <hr class="m-0" />

                <div class="dialog__footer">
                    <button @click="cancel" class="dialog__cancel">Cancel</button>
                    <button class="dialog__confirm" type="submit">{{ editMode == true ? 'Edit' : 'Add' }} Task</button>
                </div>
            </form>

        </div>

    </div>
</template>
  
<script>
export default {
    props: ['show', 'cancel', 'confirm', 'editMode', 'editTask'],
    data() {
        return {
            id: '',
            todo: '',
            description: '',
            day: new Date().toISOString().substr(0, 10),
            completed: false,
            user_id: '',
        };
    },
    methods: {
        onSubmit() {
            console.log("Submitted");

            // if (this.todo.length < 0) {
            //     alert('Please enter a Task');
            // }

            const userDataString = localStorage.getItem('userData');
            const userData = JSON.parse(userDataString);
            // this.onAddTask({
            //     id: Math.floor(Math.random() * 1000),
            //     todo: this.todo,
            //     description: this.description || " xNo Description",
            //     day: this.day,
            //     completed: this.completed,
            //     user_id: userData.user_id
            // });

            let todos = JSON.parse(localStorage.getItem('Todos')) || [];
            const newTodo = {
                id: Math.floor(Math.random() * 1000),
                todo: this.todo,
                description: this.description || " No Description",
                day: this.day,
                completed: this.completed,
                user_id: userData.user_id
            }
            // console.log(this.onAddTask);
            todos.push(newTodo);
            localStorage.setItem('Todos', JSON.stringify(todos))
            this.$emit('add-task', newTodo);
            this.id = ''
            this.todo = '';
            this.description = '';
            this.day = new Date().toISOString().substr(0, 10);
            this.completed = false
        },
        // editTask(id) {
        //     const todoString = localStorage.getItem('Todos')
        //     const todoData = JSON.parse(todoString) || [];
        //     if(todoData.id===id){
        //         const data={
        //             todo: todoData.todo,
        //             description: todoData.description,
        //             day: todoData.day,
        //             completed: todoData.completed
        //         }

        //     }
        // }

        setData(data) {
            // Set form data for editing
            this.id = data.id;
            this.todo = data.todo;
            this.description = data.description;
            this.day = data.day;
            this.completed = data.completed;
        }
    },
}

</script>

<style scoped>
table {
    justify-content: left;
}

table tr {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 8px;
}

table tr td input {
    width: 278%;
    border: none;
    opacity: 0.7;
    border-bottom: 1px solid #e5e3e3;
    padding: 5px;
}

table tr td input:focus {
    border-color: transparent;
}

.overlay {
    --tw-bg-opacity: 1;
    background-color: rgba(0, 0, 0, var(--tw-bg-opacity));
    --tw-bg-opacity: 0.5;
    height: 100%;
    position: fixed;
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
    width: 100%;
    z-index: 10;
}

.dialog {
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    border-radius: 0.75rem;
    margin-left: auto;
    margin-right: auto;
    margin-top: 9.5rem;
    max-width: 100%;
    width: 38rem;
    padding: 8px;
    padding-top: 0;
}

.dialog__content {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.dialog__title {
    font-weight: 500;
    font-size: 1.125rem;
    line-height: 1.75rem;
    margin-bottom: 0.5rem;
    --tw-text-opacity: 1;
    color: rgba(17, 24, 39, var(--tw-text-opacity));
}

.dialog__description {
    font-size: 0.875rem;
    line-height: 1.25rem;
    margin-bottom: 1rem;
    --tw-text-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-text-opacity));
}

.dialog__footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 0.6rem;
}

.dialog__cancel {
    opacity: 0.6;
    border-radius: 0.75rem;
    font-weight: 500;
    margin-right: 1rem;
    height: 41px;
    padding: 0 15px;
    border: none;
    background-color: #e4e4e4;
    transition: 0.3s;
}

.dialog__cancel:hover {
    opacity: 0.8;
}

.dialog__confirm {
    opacity: 0.5;
    background-color: #29b5ad;
    border-radius: 0.75rem;
    font-weight: 500;
    margin-right: 1rem;
    height: 41px;
    padding: 0 15px;
    border: none;
    color: white;
    transition: 0.3s;
}

.dialog__confirm:hover {
    opacity: 0.7;
}
</style> -->

<template>
    <div v-show="show" class="overlay">
        <div class="dialog">
            <form @submit.prevent="onSubmit">
                <table>
                    <tr>
                        <td class="title">
                            <input type="text" placeholder="Task name" v-model="todo" :name='this.todo' required />
                        </td>
                    </tr>
                    <tr>
                        <td class="desc">
                            <input type="text" placeholder="Description" v-model="description" />
                        </td>
                    </tr>
                    <tr>
                        <td class="day">
                            <input type="date" v-model="day" />
                        </td>
                    </tr>
                    <tr>
                        <td>Set reminder </td>
                        <td><input type="checkbox" v-model="completed"></td>
                    </tr>
                    <!-- <tr>
                        <td>
                            <button type="submit" class="addTask">
                                {{ editMode ? "Edit Task" : "Add Task" }}
                            </button>
                        </td>
                    </tr> -->
                </table>
                <hr class="m-0" />

                <div class="dialog__footer">
                    <button @click="cancel" class="dialog__cancel">Cancel</button>
                    <button class="dialog__confirm" type="submit">{{ editMode ? 'Edit' : 'Add' }} Task</button>
                </div>
            </form>
            <!-- <button @click="cancel" class="close">Close</button> -->
        </div>
    </div>
</template>
  
<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true,
        },
        editMode: {
            type: Boolean,
            default: false,
        },
        editTask: {
            type: Object,
            default: () => ({}),
        },
        cancel: {
            type: Function,
            required: true,
        },
    },
    data() {
        return {
            todo: this.editTask?.todo || "",
            description: this.editTask?.description || "",
            day: this.editTask?.day || new Date().toISOString().substr(0, 10),
            completed: this.editTask?.completed || false,
        };
    },
    methods: {
        onSubmit() {
            const userInfoString = localStorage.getItem('userData')
            const userInfo = JSON.parse(userInfoString);
            let userId = userInfo.user_id;
            this.$emit("add-task", {
                id: this.editTask?.id || Math.floor(Math.random() * 1000),
                todo: this.todo,
                description: this.description || "No description",
                day: this.day,
                completed: this.completed,
                user_id: userId || 1,
            });
        },
    },
};
</script>
  
<style scoped>
table {
    justify-content: left;
}

table tr {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 8px;
}

table tr td input {
    width: 278%;
    border: none;
    opacity: 0.7;
    border-bottom: 1px solid #e5e3e3;
    padding: 5px;
}

table tr td input:focus {
    border-color: transparent;
}

.overlay {
    --tw-bg-opacity: 1;
    background-color: rgba(0, 0, 0, var(--tw-bg-opacity));
    --tw-bg-opacity: 0.5;
    height: 100%;
    position: fixed;
    top: 0px;
    right: 0px;
    bottom: 0px;
    left: 0px;
    width: 100%;
    z-index: 10;
}

.dialog {
    --tw-bg-opacity: 1;
    background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
    border-radius: 0.75rem;
    margin-left: auto;
    margin-right: auto;
    margin-top: 9.5rem;
    max-width: 100%;
    width: 38rem;
    padding: 8px;
    padding-top: 0;
}

.dialog__content {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.dialog__title {
    font-weight: 500;
    font-size: 1.125rem;
    line-height: 1.75rem;
    margin-bottom: 0.5rem;
    --tw-text-opacity: 1;
    color: rgba(17, 24, 39, var(--tw-text-opacity));
}

.dialog__description {
    font-size: 0.875rem;
    line-height: 1.25rem;
    margin-bottom: 1rem;
    --tw-text-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-text-opacity));
}

.dialog__footer {
    display: flex;
    justify-content: flex-end;
    padding-top: 0.6rem;
}

.dialog__cancel {
    opacity: 0.6;
    border-radius: 0.75rem;
    font-weight: 500;
    margin-right: 1rem;
    height: 41px;
    padding: 0 15px;
    border: none;
    background-color: #e4e4e4;
    transition: 0.3s;
}

.dialog__cancel:hover {
    opacity: 0.8;
}

.dialog__confirm {
    opacity: 0.5;
    background-color: #29b5ad;
    border-radius: 0.75rem;
    font-weight: 500;
    margin-right: 1rem;
    height: 41px;
    padding: 0 15px;
    border: none;
    color: white;
    transition: 0.3s;
}

.dialog__confirm:hover {
    opacity: 0.7;
}
</style> 