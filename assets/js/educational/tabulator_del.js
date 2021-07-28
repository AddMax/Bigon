// CSS or SCSS
// import 'tabulator-tables/dist/css/bootstrap/tabulator_bootstrap4.min.css';
import '/assets/styles/educational/tables.scss';

import 'jquery-ui/ui/core.js';
import 'jquery-ui/ui/widgets/sortable.js';
import 'jquery-contextmenu/dist/jquery.contextMenu.js';
import 'jquery-contextmenu/dist/jquery.ui.position.js';
import 'jquery-contextmenu/dist/jquery.contextMenu.min.css';

import Tabulator from 'tabulator-tables';

$(document).ready(function () {

    console.log('Tabulator');

    $("#sortable tbody").sortable();

    function calculateColumn(index = 0) {
        let total = 0;
        $('table#sortable tbody tr').each(function () {
            let value = parseInt($('td', this).eq(index).text());
            if (!isNaN(value)) {
                total += value;
            }
        });
        return total;
    }

    $('div#example-summa').text('Сумма первого столцца = '+ calculateColumn());

    
    // ---- Contex Menu 
    $.contextMenu({
        selector: '.context-menu-one',
        trigger: 'left',
        autoHide: true,
        callback: function (key, options) {
            var m = "clicked: " + key;
            window.console && console.log(m) || alert(m);
        },
        items: {
            "addGroup": { name: "Добавить группу", icon: "edit" },
            "cut": { name: "Cut", icon: "cut" },
            copy: { name: "Copy", icon: "copy" },
            "paste": { name: "Paste", icon: "paste" },
            "delete": { name: "Delete", icon: "delete" },
            "sep1": "---------",
            "quit": {
                name: "Quit", icon: function () {
                    return 'context-menu-icon context-menu-icon-quit';
                }
            }
        }
    });

    $('.context-menu-one').on('click', function (e) {
        console.log('clicked', this);
    })

    // ---- Contex Menu 




    //define some sample data
    var tabledata = [
        { id: 1, name: "Oli Bob", location: "United Kingdom", gender: "male", rating: 1, col: "red", dob: "14/04/1984" },
        { id: 2, name: "Mary May", location: "Germany", gender: "female", rating: 2, col: "blue", dob: "14/05/1982" },
        { id: 3, name: "Christine Lobowski", location: "France", gender: "female", rating: 0, col: "green", dob: "22/05/1982" },
        { id: 4, name: "Brendon Philips", location: "USA", gender: "male", rating: 1, col: "orange", dob: "01/08/1980" },
        { id: 5, name: "Margret Marmajuke", location: "Canada", gender: "female", rating: 5, col: "yellow", dob: "31/01/1999" },
        { id: 6, name: "Frank Harbours", location: "Russia", gender: "male", rating: 4, col: "red", dob: "12/05/1966" },
        { id: 7, name: "Jamie Newhart", location: "India", gender: "male", rating: 3, col: "green", dob: "14/05/1985" },
        { id: 8, name: "Gemma Jane", location: "China", gender: "female", rating: 0, col: "red", dob: "22/05/1982" },
        { id: 9, name: "Emily Sykes", location: "South Korea", gender: "female", rating: 1, col: "maroon", dob: "11/11/1970" },
        { id: 10, name: "James Newman", location: "Japan", gender: "male", rating: 5, col: "red", dob: "22/03/1998" },
    ];

    //create Tabulator on DOM element with id "example-table"
    var table = new Tabulator("#example-table", {
        headerHozAlign: "center",
        columnHeaderVertAlign: "middle",
        layout: "fitColumns",
        data: tabledata,
        placeholder: "Загрузка данных...",
        movableRows: true,
        //--группировка
        groupBy: ["col", "gender"],
        // groupToggleElement: false,
        groupHeader: function (value, count, data, group) {
            return value + '<span style="color:#d00; margin-left:10px;">(' + count + ')</span>';
        },
        groupContextMenu: [
            {
                label: "Добавить предмет в группу",
                action: function (e, group) {
                    group.show();
                    let key = group.getKey();
                    let ttt = group.getTable();
                    ttt.addData([{
                        name: 'тест название',
                        col: key
                    }], true);
                }
            },
            {
                label: "Создать подгруппу",
                action: function (e, group) {
                    //e - context click event
                    //group - group component for group
                    group.toggle()();
                }
            },
            {
                label: "Скрыть\/Показать",
                action: function (e, group) {
                    //e - context click event
                    //group - group component for group
                    group.toggle()();
                }
            },
        ],
        columns: [
            { rowHandle: true, formatter: "handle", headerSort: false, frozen: true, width: 30, minWidth: 30 },
            { title: "N", field: "num", vertAlign: "center" },
            { title: "Название", field: "name", width: 200, editor: "input" },
            { title: "Экзамены", field: "rating", headerVertical: "flip", editor: "input" },
            { title: "Зачеты", field: "offsets", headerVertical: "flip", editor: "input" },
            {//create column group
                title: "Количество академических часов",
                columns: [
                    { title: "Всего", field: "vsego", headerVertical: "flip", editor: "input" },
                    { title: "Аудиторных", field: "auditorni", headerVertical: "flip", editor: "input" },
                    {
                        title: "Из них",
                        columns: [
                            { title: "Лекции", field: "lecture", headerVertical: "flip", editor: "input" },
                            { title: "Лабораторные", field: "laba", headerVertical: "flip", editor: "input" },
                            { title: "Практические", field: "praktika", headerVertical: "flip", editor: "input" },
                            { title: "Семинарские", field: "seminar", headerVertical: "flip", editor: "input" },
                        ]
                    },
                ],
            },
            {//create column group
                title: "Personal Info",
                columns: [
                    { title: "Gender", field: "gender", width: 90 },
                    { title: "Favourite Color", field: "col", width: 140 },
                    { title: "Date Of Birth", field: "dob", hozAlign: "center", sorter: "date", width: 130 },
                ],
            },
        ],
    });


    $("#add-row").on("click", function () {
        table.addRow({});
    });

    $("#addSubjectInputButton").on("click", function () {

        // let txt = $('#inputSubjectInputButton').val();

        // table.addData([{ 
        //     name: 'тест название',
        //     col: $(this).data('group')
        //  }], true);

        console.log('test');
        // table.addRow({});
    });

    $("#addSubjectButton").on("click", function (e) {
        console.log($(this).data('group'));
    });

    $("#addGroupInputButton").on("click", function () {
        let txt = $('#inputGroupInputButton').val();
        let e = [],
            groups = table.getGroups();

        groups.map(function (elm) {
            e.push(elm.getKey());
        });

        e.push(txt)

        // console.log(groups, txt, e);

        table.setGroupValues([e]);
    });


});
