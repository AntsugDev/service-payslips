import { createStore } from 'vuex'
import Config from "../store/modules/Config";
import User from "../store/modules/User";
import Snackbar from "../store/modules/Snackbar";
import Commons from "../store/modules/Commons";

const store = createStore({
    modules: {
        config: Config,
        user: User,
        snackbar: Snackbar,
        commons: Commons,
    }
})

export default store;