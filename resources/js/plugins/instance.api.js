import axios from "axios";
import {ca} from "vuetify/locale";


export const axiosInstance =($url, $method, $token, $body,  $includes) => {

    let $apiUrl = window.appConfig.appUrl+'/'+$url;
    if($includes !== undefined) {
        if (typeof $includes === 'object')
            $apiUrl += $apiUrl + "?includes=" + $includes.join(',');
        else if(typeof $includes === 'string')
        $apiUrl += $apiUrl + "?includes=" + $includes;
    }

    return new Promise((resolve) => {
        if($body === undefined){
            if($token !== undefined)
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + $token
                    },
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e =>snackBar(e))
            else
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e =>snackBar(e))
        }else{
            if($token !== undefined)
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization' : 'Bearer '+$token
                    },
                    data:$body,
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e =>snackBar(e))
            else
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    data:$body,
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e =>snackBar(e))
        }


    })

}


export const POST = 'POST';
export const GET = 'GET';
export const DELETE = 'DELETE';
export const PUT = 'PUT';
export const PATCH = 'PATCH';

const Error = (e) => {
    if(e.response.data !== null)
        return e.response.status+' - '+e.response.data;

    return e.response.status+' - '+e.text || e.message;
}

const snackBar = (e) => {
    this.$store.commit('snackbar/update',{
        show: true,
        color: 'red',
        text: Error(e)
    })
}

