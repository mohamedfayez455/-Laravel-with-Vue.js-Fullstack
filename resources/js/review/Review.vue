<template>
    <div>
        <fatal-error v-if="error"></fatal-error>
        <success v-if="success">You have left review, thank you very much!</success>
        <div class="row" v-if="!error && !success">

            <div :class="[{'col-md-4' :twoColumn},{'d-none' : oneColumn}]" >
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading"> loading...........</div>
                        <div v-if="hasBooking">
                            <p>
                                Stayed at
                                <router-link :to="{name:'product' ,params:{id:booking.product.product_id}}">{{booking.product.title}}</router-link>
                            </p>
                            <p>Form {{booking.from}} to {{booking.to}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div :class="[{'col-md-8' : twoColumn},{'d-none' : oneColumn}]" >
                <div v-if="loading">
                    <h4>loading............</h4>
                </div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        <h4>you may left your review </h4>
                    </div>
                    <div v-else>
                        <div>
                            <div class="form-group">
                                <label class="text-muted">Select the star rating (1 is worst - 5 is best)</label>
                                <star-rating v-model="review.rating" class="fa-3x" ></star-rating>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">Describe your expirience with</label>
                                <textarea name="content" v-model="review.content" :class="[{'is-invalid' : errorFor('content')}]" cols="30" rows="10" class="form-control"></textarea>
                                <v-error :errors="errorFor('content')"></v-error>
                            </div>
                            <button @click.prevent="submit" :disabled="sending" class="btn btn-block btn-lg btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {is404 , is422} from './../shared/utils/response';
import ValidationErrorsFunction from '../shared/mixins/ValidationErrosrFunction';
    export default {
        mixins : [ValidationErrorsFunction],
        data(){
            return{
                review:{
                    id:null,
                    rating:5,
                    content:null,
                },
                existingReview:null,
                loading:false,
                sending:false,
                booking:null,
                error:false,
                success:false
            }
        },
        // created with promise
        // created(){
        //     this.review.id = this.$route.params.id;
        //     this.loading = true;
        //     axios.get(`/api/reviews/${this.review.id}`)
        //     .then(response =>{this.existingReview = response.data.data()})
        //     .catch((error)=>{
        //         if(is404(error)){
        //             return axios.get(`/api/booking-by-review/${this.review.id}`).
        //             then(response =>{
        //                 this.booking = response.data.data
        //             })
        //             .catch((error)=>{this.error = !is404(error)})
        //         }
        //     })
        //     .then(()=>(this.loading = false));
        // },

        // created with sync
        async created(){
            this.review.id = this.$route.params.id;
            this.loading = true;
            this.success = false;
            try {
                this.existingReview = (await axios.get(`/api/reviews/${this.review.id}`)).data.data;
            }catch (error){
                if(is404(error)){
                    try {
                        this.booking = (await axios.get(`/api/booking-by-review/${this.review.id}`)).data.data;
                    }catch (error) {
                        this.error = !is404(error)
                    }
                }else{
                    this.error = !is404(error)
                }
            }
            this.loading = false;
        },

        computed:{
            alreadyReviewed(){
                return this.hasReview || !this.booking;
            },
            hasReview(){
                return this.existingReview != null ;
            },
            hasBooking(){
                return this.booking != null;
            },
            oneColumn(){
                return !this.loading && this.alreadyReviewed
            },
            twoColumn(){
                return this.loading || !this.alreadyReviewed
            },
        },
        methods:{
            submit(){
                this.sending = true;
                this.errors = null;
                axios.post(`/api/reviews`, this.review)
                    .then(response=> {this.success  = response.status == 201;})
                    .catch(error=>{
                        if (is422(error)){
                            const errors = error.response.data.errors;
                            if(errors["content"] && _.size(errors) == 1){
                                this.errors = errors;
                                return;
                            }
                        }
                        this.error = true;
                    })
                    .then(()=>{this.sending = false});
            }
        }
    }
</script>
