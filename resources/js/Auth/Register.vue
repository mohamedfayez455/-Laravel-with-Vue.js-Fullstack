<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Type your name" class="form-control"  v-model="user.name"

                    />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Type your email" class="form-control"  v-model="user.email"

                    />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Type your Password"  v-model="user.password"

                    />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Re-type Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="re-type your password" v-model="user.password_confirmation"

                    />
                </div>

                <button type="submit" @click.prevent="Register" class="btn btn-primary btn-lg btn-block">Register</button>
                <hr>
                 <div>
                     login ?
                     <router-link :to="{name:'login'}" class="font-weight-bold" >Login</router-link>
                 </div>
            </form>
        </div>
    </div>
</template>

<script>
import ValidationErrorsFunction from '../shared/mixins/ValidationErrosrFunction';
import {LogIn} from "../shared/utils/auth";
    export default {
        mixins:[ValidationErrorsFunction],
        data(){
            return{
                user:{
                    name:null,
                    email:null,
                    password:null,
                    password_confirmation:null,
                },
                loading:false,
            }
        },
        methods:{
            async Register(){
                this.loading = true;
                this.errors = null;
                try {
                    const response = await axios.post('/register',this.user);
                    if (response.status == 201){
                        LogIn();
                        this.$store.dispatch("loadUser");
                        this.$router.push({name:"home"});
                    }
                }catch (error) {
                    alert(error)
                }
                this.loading = false;
            }
        }
    }
</script>
