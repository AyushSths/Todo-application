<template>
    <div class="user_mang">
        <form id="user_form">
            <div class="user_details">
                <div class="user_name">
                    <h6>Name</h6>
                    <input type="text" :value="users.name" disabled>
                    <br>
                    <button @click.prevent="changeName = true" class="change mt-2">Change Name</button>
                    <form v-if="changeName" class="email_change mt-2" @submit.prevent="updateUser('name')">
                        <p>New Name</p>
                        <input type="text" v-model="newName" required />
                        <div class="btn">
                            <button @click="changeName = false" class="cancel">Cancel</button>
                            <button class="confirm">Confirm</button>
                        </div>
                    </form>
                </div>
                <hr style="border: 1px solid #f5f5f5 ;">
                <div class="user_email">
                    <h6>Email</h6>
                    <p style="opacity: 0.8;">{{ users.email }}</p>
                    <button @click.prevent="showEmailForm = true" class="change">Change Email</button>
                    <form v-if="showEmailForm" class="email_change mt-2" @submit.prevent="updateUser('email')">
                        <small>Update the email you use for your TODO account.</small>
                        <p>New Email</p>
                        <input type="email" v-model="newEmail" required />

                        <div class="btn">
                            <button @click="showEmailForm = false" class="cancel">Cancel</button>
                            <button class="confirm">Confirm</button>
                        </div>
                    </form>
                </div>
                <div class="user_pwd">
                    <h6>Password</h6>
                    <button @click.prevent="showPwdForm = true" class="change">Change password</button>
                    <form v-if="showPwdForm" class="pwd_change mt-2" @submit.prevent="updateUser('password')">
                        <small>Update the password you use for your TODO account.</small>
                        <p>Old password</p>
                        <input type="password" v-model="oldPassword" required />
                        <p>New password</p>
                        <input type="password" v-model="newPassword" minlength="6" required />
                        <p>Confirm new password</p>
                        <input type="password" v-model="confirmPassword" required />
                        <div class="btn">
                            <button @click="showPwdForm = false" class="cancel">Cancel</button>
                            <button class="confirm">Confirm</button>
                        </div>
                    </form>
                </div>
                <hr style="border: 1px solid #f5f5f5 ;">
                <div class="del_acc">
                    <h6>Delete account</h6>
                    <button @click.prevent="showDelForm = true">Delete account</button>
                    <form v-if="showDelForm" class="email_change mt-2" @submit.prevent="deleteUser">
                        <p>Your current password is required to delete the account</p>
                        <input type="password" v-model="delPassword" required /><br>
                        <small>Deleting your account is permanent.<b> All your data will be wiped out immediately</b> and
                            you won't
                            be able to get it back.</small>
                        <div class="btn">
                            <button @click="showDelForm = false" class="cancel" style="color:black;">Cancel</button>
                            <button class="confirm">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: [],
            newName: '',
            newEmail: '',
            oldPassword: '',
            newPassword: '',
            confirmPassword: '',
            delPassword: '',
            showEmailForm: false,
            showPwdForm: false,
            changeName: false,
            showDelForm: false
        };
    },
    mounted() {
        this.getUsers();
    },
    // computed: {
    //     inputModel() {
    //         // Dynamically bind v-model based on changeName flag
    //         return this.changeName ? this.newName : this.name;
    //     },
    // },
    methods: {
        getUsers() {
            const userInfoString = localStorage.getItem('userData')
            const userInfo = JSON.parse(userInfoString);
            console.log("userInfo", userInfo)
            let userId = userInfo.user_id;
            console.log(this.user);
            axios.get(`http://127.0.0.1:8000/api/register/${userId}`)
                .then(response => {
                    this.users = response.data.data;
                    console.log('users', this.users);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        updateUser(field) {
            const userInfoString = localStorage.getItem('userData');
            const userInfo = JSON.parse(userInfoString);
            let existingData = JSON.parse(userInfoString);
            let userId = userInfo.user_id;
            let updateData = {};

            if (field === 'email') {
                updateData = { email: this.newEmail };
            }
            else if (field === 'name') {
                updateData = { name: this.newName };
            }
            else if (field === 'password') {
                updateData = {
                    old_password: this.oldPassword,
                    new_password: this.newPassword,
                    confirm_password: this.confirmPassword,
                };
            }

            axios.put(`http://127.0.0.1:8000/api/register/${userId}`, updateData)
                .then(response => {
                    console.log(response.data);
                    window.location.reload();
                    alert(response.data.message);
                    console.log(response.data.message);

                    let updatedUserData = { ...existingData, ...updateData };
                    localStorage.setItem('userData', JSON.stringify(updatedUserData));
                })
                .catch(error => {

                    console.error("User update errror", error.response.data);
                    // Handle error response
                    if (error.response.data.message == "Validation Error") {
                        alert(error.response.data.errors.confirm_password)
                        console.log("Error object", error.response.data.errors.confirm_password);
                    }
                    else
                        alert(error.response.data.message);

                });

            // localStorage.setItem("userData", JSON.stringify(updateData));
        },
        deleteUser() {
            const userInfoString = localStorage.getItem('userData');
            const userInfo = JSON.parse(userInfoString);
            let userId = userInfo.user_id;

            // let data = { pwd: this.delPassword }
            // console.log("pwd", data);

            if (window.confirm('Are you sure you want to delete your account?')) {
                axios.delete(`http://127.0.0.1:8000/api/register/${userId}`, {
                    data: {
                        password: this.delPassword,
                    },
                })
                    .then(
                        response => {
                            console.log("user deleted", response);
                            alert(response.data.message);
                            localStorage.removeItem("userData");
                            window.location = '/';
                        }
                    )
                    .catch(error => {
                        console.error("Error deleting user", error);
                        alert(error.response.data.message);
                    });
            }

            console.log("Delete button clicked");

        },
    }
}
</script>

<style scoped>
#user_form {
    margin: auto;
    margin-top: 30px;
    width: 50%;
}

.user_details {
    margin: auto;
    background-color: #f5f5f5;
    border-radius: 10px;
    padding: 25px;
    text-align: left;
    max-height: 750px;
    overflow-y: auto;
    scrollbar-width: thin;
}

.user_details div {
    /* display: flex; */
    margin-bottom: 20px;
}

.user_details div form input,
.user_details div input {
    padding: 2px;
    padding-left: 5px;
    opacity: 0.6;
    width: 50%;
    border-color: 1px solid #f5f5f5;
    box-sizing: border-box;
}

.user_details div form input {
    margin-bottom: 5px;
}

.user_details div form p {
    font-weight: 600;
    margin-bottom: 2px;
    font-size: 14px;
    opacity: 0.8;
}

.btn {
    display: block;
    text-align: left;
}

.btn button {
    margin-right: 5px;
}

.btn .confirm {
    opacity: 0.8;
    background-color: #29b5ad;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 16px;
    margin-right: 1rem;
    height: 35px;
    padding: 0 15px;
    border: none;
    color: white;
    transition: 0.3s;
}

.btn .confirm:hover {
    opacity: 1;
}

.btn .cancel {
    opacity: 0.6;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 16px;
    margin-right: 1rem;
    height: 35px;
    padding: 0 15px;
    border: none;
    background-color: #e4e4e4;
    transition: 0.3s;
}

.btn .cancel:hover {
    opacity: 0.8;
}

.change {
    opacity: 0.7;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 14px;
    margin-right: 1rem;
    height: 30px;
    padding: 0 15px;
    border: none;
    background-color: #e4e4e4;
    transition: 0.3s;
}

.change:hover {
    opacity: 1;
}

.del_acc button {
    opacity: 0.5;
    background-color: red;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 16px;
    margin-right: 1rem;
    height: 35px;
    padding: 0 15px;
    border: none;
    color: white;
    transition: 0.3s;
}

.del_acc button:hover {
    opacity: 0.6;
}

h6 {
    font-weight: 700;
}

@media(max-width:800px) {
    #user_form {
        width: 80%;
    }
}
</style>
  