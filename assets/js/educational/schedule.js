import '/assets/styles/educational/schedule.scss'; 
// import '../../styles/educational/schedule.scss';

import { Application, Controller } from "stimulus";

require('./cellSelection');

const application = Application.start();
application.register("schedule", class extends Controller {

    rimCourses = { 1: 'I', 2: 'II', 3: 'III', 4: 'IV', 5: 'V', 6: 'VI' };

    connect() {

        this.csd = $('#example_default').cellSelection({
            selectClass: 'table-active', // имя своего класса для стилизации выделяемый ячеек. По умолчанию "jq-cell-selected"
            ignoreCell: 'ignore-selector' // селектор игнорируемых ячеек (id, класс, атрибут etc.) По умолчанию - нет
        });

    }

    praktikaProisvod(event) {
        event.preventDefault();
        $('#example_default tbody tr td.table-active').html('X');
        this.updateForm();
    }

    sessiaExam(event) {
        event.preventDefault();
        $('#example_default tbody tr td.table-active').html(':');
        this.updateForm();
    }

    theoretical(event) {
        event.preventDefault();
        $('#example_default tbody tr td.table-active').html('&nbsp;');
        this.updateForm();
    }

    praktikaUchebna(event) {
        event.preventDefault();
        $('#example_default tbody tr td.table-active').html('O');
        this.updateForm();
    }
    
    holiday(event) {
        event.preventDefault();
        $('#example_default tbody tr td.table-active').html('=');
        this.updateForm();
    }

    certification(event) {
        event.preventDefault();
        $('#example_default tbody tr td.table-active').html('//');
        this.updateForm();
    }

    updateForm() {
        // $('form[name="form"] button:submit').hide();
        $('form[name="form"] button:submit').prop('disabled', false).show();
        $('form[name="form"] input:hidden[name*="educationalSchedule"]').val(this._tableToJson());

        // let educationalPlan = JSON.parse($("input:hidden[name*='educationalPlan']").val());
    }

    _tableToJson() {
        let e = [],
            table = $('#example_default tbody tr').slice(1);
        table.each(
            (e_ind, e_el) => {
                e.push({
                        'cours': $(e_el).data('cours'),
                        'datas': $('td', e_el).map(
                            (m_ind, m_el) => {
                                return {
                                    'val': $(m_el).html(),
                                    'week': $(m_el).data('week'),
                                };
                            }
                        ).get()
                    })
            });
        return JSON.stringify(e);
    }

    addCourse(event) {
        event.preventDefault();

        console.log('addCourse');

        let length = $('#example_default tbody tr').length,
            prototype = $('#example_default tbody tr#prototype').clone(),
            num;

        num = length == 1 ? 1 : Number($('#example_default tbody tr:last').find('th:eq(0)').html()) + 1;
        prototype.find('th:eq(0)').html(num);
        prototype.find('th:eq(1)').html(this.rimCourses[num]);
        prototype.find('td').removeClass().html('&nbsp;');

        let newTableRow = '<tr data-cours="' + num + '" >' + prototype.html() + '</tr>';
        $('#example_default tbody tr:last').after(newTableRow);

        this.connect();

        this.updateForm();
    }

    removeCourse(event) {
        event.preventDefault();

        console.log('removeCourse');
        let length = $('#example_default tbody tr').length;
        if (length > 1) $('#example_default tbody tr:last').remove();

        this.connect();
        
        this.updateForm();
    }


    clear(event) {
        event.preventDefault();

        let table = $('#example_default tbody tr').slice(1);
        table.find('td').html('&nbsp;');

        this.updateForm();
    }

});
