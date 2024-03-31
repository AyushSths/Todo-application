<template>
    <div class="register_form">
        <form class="form_main" @submit.prevent="saveData">
            <p class="heading">Sign up</p>
            <div class="inputContainer">
                <svg class="inputIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#2e2e2e"
                    viewBox="0 0 16 16">
                </svg>
                <input type="text" v-model="users.name" class="inputField" name="name" id="name" placeholder="Username"
                    required>
            </div>
            <div class="inputContainer">
                <svg class="inputIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#2e2e2e"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z">
                    </path>
                </svg>
                <input type="email" v-model="users.email" name="email" class="inputField" id="email" placeholder="Email"
                    required>
            </div>

            <div class="inputContainer">
                <svg class="inputIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#2e2e2e"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
                    </path>
                </svg>
                <input type="password" v-model="users.password" name="password" class="inputField" id="password"
                    placeholder="Password" required>
                <!-- <span v-for="error in v$.name.$errors" :key="error.$uid">{{ error.$message }}</span> -->
            </div>


            <button id="button" @click="checkForm">Sign up</button>
            <p style="opacity: 0.7;z-index:1;">Already have an account? <router-link to="/login" class="'link'">Log
                    In!</router-link>
            </p>
        </form>
        <!-- <div>
            <form @submit.prevent="saveData">
                <label for="username">Username:</label><br>
                <input type="text" v-model="users.name" name="name"><br>
                <label for="email">Email Address:</label><br>
                <input type="email" v-model="users.email" name="email" required><br>
                <label for="password">Password:</label><br>
                <input type="password" v-model="users.password" name="password" minlength=8 required><br>
                <span style="color:red;">{{ errorMsg }}</span><br>
                <button type="submit">Submit</button>
            </form>
        </div> -->
    </div>
</template>
  
<script>

import axios from 'axios';
// import useVuelidate from '@vuelidate/core'
// import { required } from "@vuelidate/validators";

export default {
    name: 'RegisterPage',
    data() {
        return {
            msg: "Register user",
            result: {},
            users: {
                name: '',
                email: '',
                password: ''
            },
            // rules: {
            //     name: {
            //         required,
            //     },
            //     email: {
            //         required,
            //     },
            //     password: {
            //         required
            //     }
            // }
        }
    },
    methods: {

        // checkForm() {
        //     const v$ = useVuelidate(this.rules, this.users);
        //     this.result = v$.value.$validate();
        // },

        saveData() {
            axios.post("http://127.0.0.1:8000/api/register", this.users)
                .then(
                    ({ data }) => {
                        console.log(data);
                        try {
                            if (data['status'] === true) {
                                alert('You have successfully registered!')
                                this.users.name = '';
                                this.users.email = '';
                                this.users.password = '';
                                window.location = "/login";
                            } else {
                                console.log(data.message);
                            }
                            // alert("Signed up!!!")
                        } catch (err) {
                            // alert(`Registration failed!\nError message:\n${JSON.stringify(data)}`)
                            alert("Failed" + " " + data.message)
                            console.log("failed", err);
                        }
                    }
                )
                .catch(error => {
                    console.log(error.response.data);
                    alert(error.response.data.message);
                })
        }
    }
}
</script>
  
  <!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.form_main {
    margin: auto;
    width: 45vh;
    height: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #dbf7f6;
    padding: 30px 30px 30px 30px;
    box-shadow: -14px 20px 8px #29b5ad;
    border-radius: 5px;
    position: relative;
    top: 17vh;
    overflow: hidden;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
}

.form_main::before {
    position: absolute;
    content: "";
    width: 300px;
    height: 300px;
    /* background-color: rgb(209, 193, 255); */
    background-color: #4de7de;
    transform: rotate(45deg);
    left: -180px;
    bottom: 30px;
    z-index: 1;
    border-radius: 30px;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
}

.heading {
    font-size: 2em;
    color: #2e2e2e;
    font-weight: 700;
    margin: 5px 0 10px 0;
    z-index: 2;
}

.inputContainer {
    width: 100%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    margin-bottom: 15px;
}

.inputIcon {
    position: absolute;
    left: 3px;
}

.inputField {
    width: 100%;
    height: 55px;
    background-color: transparent;
    border: none;
    border-bottom: 2px solid rgb(173, 173, 173);
    margin: 10px 0;
    color: black;
    font-size: .8em;
    font-weight: 500;
    box-sizing: border-box;
    padding-left: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 17px;
    opacity: 0.8;
}

.inputField:focus {
    outline: none;
    border-bottom: 2px solid rgb(199, 114, 255);
}

.inputField::placeholder {
    color: rgb(80, 80, 80);
    font-size: 1em;
    font-weight: 500;
}

#button {
    z-index: 2;
    position: relative;
    width: 100%;
    border: none;
    border-radius: 5px;
    /* background-color: rgb(162, 104, 255); */
    background-color: #29b5ad;
    height: 44px;
    color: white;
    font-size: .8em;
    font-weight: 500;
    letter-spacing: 1px;
    margin: 10px;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    font-size: 20px;
    cursor: pointer;
    transition: 0.4s ease;
}

#button:hover {
    /* background-color: rgb(126, 84, 255); */
    background-color: #249791;
}

.forgotLink {
    z-index: 2;
    font-size: .7em;
    font-weight: 500;
    color: rgb(44, 24, 128);
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 20px;
}
</style>
  