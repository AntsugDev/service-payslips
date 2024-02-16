import axios from "axios";
export const axiosInstance =($url, $method, $token, $body,  $includes) => {

    let $apiUrl = window.appConfig.appUrl+$url;
    if($includes !== undefined) {
        if (typeof $includes === 'object')
            $apiUrl += "?includes=" + $includes.join(',');
        else if(typeof $includes === 'string')
        $apiUrl += "?includes=" + $includes;
    }

    return new Promise((resolve,reject) => {
        if($body === undefined){
            if($token !== undefined)
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + $token
                    },
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e => {
                    reject(e)
                })
            else
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                    },
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e => {
                    reject(e)
                })
        }else{
            if($token !== undefined)
                axios.request({
                    url: $apiUrl,
                    method: $method,
                    headers: {
                        'Accept': 'application/json',
                        'Authorization' : 'Bearer '+$token
                    },
                    data:{data:$body},
                    timeout: 180000,
                }).then(r => resolve(r)).catch(e => {
                    reject(e)
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
                }).then(r => resolve(r)).catch(e => {
                    reject(e)
                })
        }


    })

}


export const POST = 'POST';
export const GET = 'GET';
export const DELETE = 'DELETE';
export const PUT = 'PUT';
export const PATCH = 'PATCH';


const Status  = (code) => {
    switch (parseInt(code)){
        case 404:
            return "not found";
        case 422:
            return "exception";
    }
}

const Error = (e) => {
    if(e.response.data !== null)
        return e.response.status+' - '+e.response.data.error;
    return e.response.status+' - '+e.text || e.message;
}

const snackBar = (e,$store) => {
    $store.commit('snackbar/update',{
        show: true,
        color: 'red',
        text: Error(e)
    })
}

