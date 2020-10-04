import Vue from "vue"
import VueRouter from "vue-router"
import NProgress from "nprogress"
import store from "./store"
import Home from "./views/Home"
import Explore from "./views/Explore"
import Profile from "./views/Profile"
import Login from "./views/Login"

Vue.use(VueRouter)

let router = new VueRouter({
	mode: "history",
	routes: [
		{ 
			path: "/", 
			name: "home", 
			component: Home, 
			meta: { auth: true } 
		},
		{ 
			path: "/explore", 
			name: "explore", 
			component: Explore 
		},
		{ 
			path: "/profile/:name", 
			name: "profile", 
			component: Profile, 
			props: true 
		},
		{ 
			path: "/login", 
			name: "login", 
			component: Login 
		}
	]
})

router.beforeEach((to, from, next) => {
	NProgress.start()

	to.meta.auth && ! store.state.auth.user ? next("/login") : next()
})

router.afterEach(() => NProgress.done())

export default router