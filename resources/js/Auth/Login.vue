<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Type your email" class="form-control"  v-model="email"

                    />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control"  v-model="password"

                    />
                </div>

                <button type="submit" @click.prevent="Login" class="btn btn-primary btn-lg btn-block">Log-in</button>
                <hr>
                 <div>
                     No account yet ?
                     <router-link :to="{name:'register'}" class="font-weight-bold" >Register</router-link>
                 </div>
                 <div>
                     Forget Password ?
                     <router-link :to="{name:'home'}" class="font-weight-bold" >Rest Password</router-link>
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
                email:null,
                password:null,
                loading:false,
            }
        },
        methods:{
            async Login(){
                this.loading = true;
                this.errors = null;
                try {
                    await axios.get('/sanctum/csrf-cookie');
                    await axios.post('/doLogin',{
                        email : this.email,
                        password : this.password,
                    });
                    LogIn();
                    this.$store.dispatch("loadUser");
                    this.$router.push({name:"home"});
                }catch (error) {
                    alert(error)
                }
                this.loading = false;
            }
        }
    }
</script>
