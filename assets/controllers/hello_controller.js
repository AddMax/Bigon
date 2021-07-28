import { Controller } from 'stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ["source"];

    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
        console.log('Hello Stimulus!');
    }

    week(event) {
        event.preventDefault();
        let url = this.sourceTarget.href;

        $.ajax({
            url: url,
            method: 'post',
            dataType: 'html',
            beforeSend: () => this._beforeSend(),
            success: (data) => this._success(data),
        });

        $("#exampleModal").modal('show');

    }

    // private

    _beforeSend() {
        $("#exampleModal").find('div.modal-body').html('Загрузка данных...');
    }

    _success(data) {
        $("#exampleModal").find('div.modal-body').html(data);
    }
}
