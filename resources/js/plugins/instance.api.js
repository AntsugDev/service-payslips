import axios from "axios";
import store from "../store/index.js";
import {handleResponseError, successResponse} from "../mixins/ResponseErrorHandler.js";
export const axiosInstance =($url, $method,  $body,  $includes) => {
    let $token = null;
    $includes = $includes === undefined ? null : $includes;
    $body = $body === undefined ? null : $body;
    if($url.indexOf('oauth') === -1) {
        let    $store = store.getters['user/getJwt']
        $token = $store.access_token
    }

    let $apiUrl = window.appConfig.appUrl+$url;
    if($includes !== null) {
        if ($includes !== 'object' && Object.keys($includes).length > 0)
            $apiUrl += "?includes=" + $includes.join(',');
        else if(typeof $includes === 'string')
            $apiUrl += "?includes=" + $includes;
    }

    return new Promise((resolve,reject) => {
        if($body === null){
            if($token !== null)
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + $token
                    },
                    timeout: 180000,
                }).then(r => {
                    let data = r.data;
                    if(data.hasOwnProperty('data') && data.data.hasOwnProperty('esito')){
                        successResponse(data.data.esito)
                    }
                    resolve(r)
                }).catch(e => {
                    // if($url.indexOf('oauth') === -1 && $url.indexOf('reset') === -1)
                    handleResponseError(e)
                    reject(e)
                    // else reject(e)
                })
            else
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                    },
                    timeout: 180000,
                }).then(r => {
                    let data = r.data;
                    if(data.hasOwnProperty('data') && data.data.hasOwnProperty('esito')){
                        successResponse(data.data.esito)
                    }
                    resolve(r)
                }).catch(e => {
                    // if($url.indexOf('oauth') === -1 && $url.indexOf('reset') === -1)
                    handleResponseError(e)
                    reject(e)
                    // else reject(e)
                })
        }else{
            if($token !== null)
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                        'Authorization' : 'Bearer '+$token
                    },
                    data:{data:$body},
                    timeout: 180000,
                }).then(r => {
                    let data = r.data;
                    if(data.hasOwnProperty('data') && data.data.hasOwnProperty('esito')){
                        successResponse(data.data.esito)
                    }
                    resolve(r)
                }).catch(e => {
                    // if($url.indexOf('oauth') === -1 && $url.indexOf('reset') === -1)
                    handleResponseError(e)
                    reject(e)
                    // else reject(e)
                })
            else
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                    },
                    data:{data:$body},
                    timeout: 180000,
                }).then(r => {
                    let data = r.data;
                    if(data.hasOwnProperty('data') && data.data.hasOwnProperty('esito')){
                        successResponse(data.data.esito)
                    }
                    resolve(r)
                }).catch(e => {
                    console.log('Error=>',JSON.stringify(e.response.data))
                    // if($url.indexOf('oauth') === -1 && $url.indexOf('reset') === -1)
                    handleResponseError(e)
                    reject(e)
                    // else reject(e)
                })
        }


    })

}


export const POST = 'POST';
export const GET = 'GET';
export const DELETE = 'DELETE';
export const PUT = 'PUT';
export const PATCH = 'PATCH';





