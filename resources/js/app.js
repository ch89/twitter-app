import Vue from "vue"
import axios from "axios"
import router from "./router"
import store from "./store"
import "nprogress/nprogress.css"
import Navbar from "./components/Navbar"
import Sidebar from "./components/Sidebar"
import Modal from "./components/Modal"

window.axios = axios
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

Vue.component("modal", Modal)

let auth = localStorage.getItem("auth")
if(auth) store.commit("auth/add", JSON.parse(auth))

let app = new Vue({
	el: "#app",
	router,
	store,
	components: { Navbar, Sidebar }
})