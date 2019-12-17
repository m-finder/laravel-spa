import axios from 'axios'
import storage from "../../../storage";
import alert from '../utils/alert';

const service = axios.create({
    timeout: 5000
});

service.interceptors.request.use(
    config => {
        // do something before request is sent
        const token = storage.get('token');
        if (token) {
            config.headers['Accept'] = 'application/json';
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        return config
    },
    error => {
        console.log('xxxx') // for debug
        console.log(error) // for debug
        Promise.reject(error)
    }
);

// 报错统一拦截
service.interceptors.response.use(
        response => {
          const res = response
            console.log(res)
          // if (res.code !== 0) {
          //   Message({
          //     message: res.message,
          //     type: 'error',
          //     duration: 5 * 1000
          //   })
          //   // 50008:非法的token; 50012:其他客户端登录了;  50014:Token 过期了;
          //   if (res.code === 50008 || res.code === 50012 || res.code === 50014) {
          //     // 请自行在引入 MessageBox
          //     // import { Message, MessageBox } from 'element-ui'
          //     MessageBox.confirm('你已被登出，可以取消继续留在该页面，或者重新登录', '确定登出', {
          //       confirmButtonText: '重新登录',
          //       cancelButtonText: '取消',
          //       type: 'warning'
          //     }).then(() => {
          //       store.dispatch('FedLogOut').then(() => {
          //         location.reload() // 为了重新实例化vue-router对象 避免bug
          //       })
          //     })
          //   }
          //   return Promise.reject('error')
          // } else {
          //   return response.data
          // }
        },
    error => {
        console.log('err') // for debug
        console.log('err' + error) // for debug
        alert.error(error.toString());
        // alert.alerts.push({'type': 'danger', 'msg': error.toString(), 'show': 10, 'down': 0})
        return Promise.reject(error)
    }
);

export default service
