export function isLoggedIn(){
    return localStorage.getItem("isLoggedIn" ) == 'true';
}

export function LogIn(){
    return localStorage.setItem("isLoggedIn" , true);
}

export function LogOut(){
    return localStorage.setItem("isLoggedIn" , false);
}
