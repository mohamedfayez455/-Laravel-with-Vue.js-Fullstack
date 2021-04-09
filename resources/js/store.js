import {isLoggedIn, LogOut} from "./shared/utils/auth";

export default {
    state:{
        lastSearch:{
            from : null,
            to : null,
        },
        basket:{
          items:[],
        },
        isLoggedIn : false,
        user:{},


    },
    getters:{
        itemsInBasket : (state) => state.basket.items.length,
        inBasketAlready (state) {
            return function (id){
                return state.basket.items.reduce(
                    (result , item) => result || item.product.id == id , false
                );
            }
        }
    },
    mutations:{
        setLastSearch(state , payload){
            state.lastSearch = payload;
        },
        addToBasket(state,payload){
            state.basket.items.push(payload);
        },
        removeFromBasket(state,payload){
            state.basket.items = state.basket.items.filter(item => item.product.id != payload );
        },
        setBasket(state , payload){
            state.basket = payload;
        },
        setUser(state , payload){
            state.user = payload;
        },
        setLoggedIn(state , payload){
            state.isLoggedIn = payload;
        },
    },
    actions:{

        LoadStoredState(context){
            // last search
            const lastSearch = localStorage.getItem('lastSearch');
            if(lastSearch){
                context.commit('setLastSearch' , JSON.parse(lastSearch));
            }
            //basket items
            const basket = localStorage.getItem('basket');
            if (basket){
                context.commit('setBasket' , JSON.parse(basket));
            }
            context.commit("setLoggedIn" , isLoggedIn());
        },
        setLastSearch(context , payload) {
            context.commit('setLastSearch' , payload);
            localStorage.setItem('lastSearch' , JSON.stringify(payload));
        },
        addToBasket({commit , state} , payload){
            commit('addToBasket' , payload);
            localStorage.setItem('basket'  ,JSON.stringify(state.basket));
        },
        removeFromBasket({commit , state} , payload){
            commit("removeFromBasket" , payload);
            localStorage.setItem('basket'  ,JSON.stringify(state.basket));
        },
        clearBasket({commit , state} , payload){
            commit("setBasket" , {items:[]});
            localStorage.setItem('basket'  ,JSON.stringify(state.basket));
        },
        async loadUser({commit , dispatch}){
            if (isLoggedIn()){
                try {
                    const user = (await (axios.get('/user'))).data;
                    commit("setUser" , user);
                    commit("setLoggedIn" , true);
                }catch (error) {
                    dispatch("logout");
                }
            }
        },
        logout({commit}){
            commit("setUser" , {});
            commit("setLoggedIn" , false);
            LogOut();
        }

    }
}
