import Vue from 'vue'

export class Errors{
    constructor(){
        this.errors = {}
    }

    get(field){
        if (this.errors[field]){
            return this.errors[field][0];
        }
    }

    record(errors){
        // console.log(errors.errors);
        this.errors = errors.errors;
    }

    clear(){
        this.errors = {}
    }

    // static get(field){
    //     if (this.errors[field]){
    //         return this.errors[field][0];
    //     }
    // }
    //
    // static record(errors){
    //     this.errors = errors.errors;
    // }
    //
    // static clear(){
    //     this.errors = {}
    // }

    static notify(error, message='', status=''){
        let type, title;
        if (status !==''){
            title = 'Error';
            type = 'error';
            message = this.setMessage(status)
        }else{
            if (error === true){
                title = 'Error';
                type = 'error';
            }else{
                title = 'Success';
                type = 'default';
            }
        }
        Vue.notify({
            title: title,
            text: message,
            type: type
        })
    }

    static Notification(response){
        var type = 'default';
        var text = '';
        let title = '';
        var message = '';
        // validation error
        if('status' in response){
            // && response.status === 422
            switch (response.status) {
                case 422:

                    type = "error";
                    if(typeof(response.data) === 'object'){
                        title += response.data.message;
                        var errors = response.data.errors;

                        // add all message to a string
                        if(typeof(errors) === 'object'){
                            for ( const key of Object.keys(errors)){
                                text += `<v-list-item> ${errors[key][0]} </v-list-item><br>` ;
                            }
                        }
                        message = `<v-list> ${text} </v-list>`;
                    }
                    break;

                case 200:
                    title += 'Success';
                    type = 'success';
                    message = response.data.message;
                    break;

                case 403:
                    title += 'Permission denied';
                    type = 'error';
                    message = response.data.message;
                    // router.push('/unauthorized');
                    break;

                case 404:
                    title += 'Resource not found';
                    type = 'error';
                    message = 'Sorry, an error has occurred, Requested Resource not found!';
                    // router.push('/page-not-found');
                    break;

                case 500:
                    title += 'Error';
                    type = 'error';
                    message = response.data.message;
                    break;

                default:
                    title += 'Message';
                    type = 'default';
                    message = response.data.message;
            }

        }

        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-bottom-right",
            "closeButton": true,
            "progressBar": true
        };
        if (type === 'success') {toastr.success(message);}
        if (type === 'error') {toastr.error(message);}

        // Vue.notify({
        //     title: title,
        //     text: message,
        //     type: type
        // })
    }

    static setMessage(code){
        let message;
        switch (code) {
            case 422:
                message = "Could not save the record. <br>Note: Check input fields with required (*) label.";
                break;
            case 403:
                message = "Permission denied";
                break;
            default:
                message = "Something went wrong";
        }

        return message;
    }
}
