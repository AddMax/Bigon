import { Controller } from 'stimulus';

/*
 *
 * Any element with a data-controller="forms" attribute will cause
 *
 */
export default class extends Controller {

    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
        console.log('Forms Stimulus!');
    }

    sendForm(event) {
        event.preventDefault();

        let $form = $(this.element);
        let url = $form.attr('action');
        let datas = $form.serialize();

        $.ajax({
            url: url,
            type: 'post',
            data: datas,
            success: (data) => {
                console.log(data);
            }
          });
        
        
        console.log('SendForms', url, datas);

        $("#exampleModal").modal('hide');
    }


}