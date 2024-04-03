import store from "../store/index.js";

export const  handleResponseError =   (error) =>  {
    let response = error.response;
    if (response === undefined) {
        store.commit('snackbar/update', {
            show: true,
            text: error.toString(),
            color: 'error'
        });
    } else {
        let status = response.status;
        if (status === 401) {
          store.commit('snackbar/update', {
                show: true,
                text: 'Sessione scaduta',
                color: 'error'
            });

        } else {
            let errors = response.data.errors;
            if (errors === undefined) {
                store.commit('snackbar/update', {
                    show: true,
                    text: response.data.message,
                    color: 'error'
                });
            } else {
                store.commit('snackbar/update', {
                    show: true,
                    text: typeof  response.data.errors  === 'string' ? response.data.errors : errors[0].detail,
                    color: 'error'
                });
            }
        }
    }
}
export const successResponse =  (msg) => {
    store.commit('snackbar/update', {
        show: true,
        text: msg,
        color: 'success'
    });
}



