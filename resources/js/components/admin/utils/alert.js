import 'izitoast/dist/css/iziToast.min.css'
import {VueIzitoast} from 'vue-izitoast'

export default {
    error: (message, title = 'Error') => {
        return VueIzitoast.error({
            title: title,
            message: message,
            position: 'bottomCenter'
        });
    },
    success: (message, title = 'Success') => {
        return VueIzitoast.success({
            title: title,
            message: message,
            position: 'bottomCenter'
        });
    }
};;