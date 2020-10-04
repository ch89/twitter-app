import Vue from "vue"
import VueRouter from "vue-router"
import NProgress from "nprogress"
import store from "./store"
import Home from "./views/Home"
import Explore from "./views/Explore"
import Notifications from "./views/Notifications"
import Profile from "./views/Profile"
import Tweets from "./views/Tweets"
import Replies from "./views/Replies"
import Media from "./views/Media"
import Likes from "./views/Likes"
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
			path: "/notifications", 
			name: "notifications", 
			component: Notifications 
		},
		{ 
			path: "/users/:name", 
			// name: "profile", 
			component: Profile, 
			props: true,
			children: [
				{ path: "", name: "tweets", component: Tweets },
				{ path: "replies", name: "replies", component: Replies },
				{ path: "media", name: "media", component: Media },
				{ path: "likes", name: "likes", component: Likes }
			]
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