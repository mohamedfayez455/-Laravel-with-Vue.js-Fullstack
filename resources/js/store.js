export default {
    state:{
        lastSearch:{
            from : null,
            to : null,
        },
        basket:{
          items:[],
        }
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
        }
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

    }
}
