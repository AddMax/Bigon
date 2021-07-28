// CSS or SCSS
import "/assets/styles/educational/tables.scss";

import "jquery-ui/ui/core.js";
import "jquery-ui/ui/widgets/sortable.js";

import "jquery-contextmenu/dist/jquery.contextMenu.min.css";
import "jquery-contextmenu/dist/jquery.contextMenu.js";
import "jquery-contextmenu/dist/jquery.ui.position.js";

import "node-json2html/json2html";

import "./tablesEditable.js";

$(document).ready(function () {

  console.log("Tabulator");


  // --- Делает таблицу drag-drop
  $("#sortable tbody").sortable({
    cursor: "move",
    cancel: ".cancel-sort",
    handle: "#sortable-handle",
    update: function (event, ui) {
      // let sortedItems = $(this).sortable("toArray");
      // console.log(
      //   ui.item.prev().length,
      //   ui.item.next().length,
      //   sortedItems,
      //   $(this)
      // );
      numberSort();
    },
  });

  function calculateColumn(index = 0) {
    let total = 0;
    $("table#sortable tbody tr").each(function () {
      let value = parseInt($("th", this).eq(index).text());
      if (!isNaN(value)) {
        total += value;
      }
    });
    return total;
  }

  $("div#example-summa").text("Сумма первого столцца = " + calculateColumn());


  // --- Создание нумерации в таблице

  function numberSort() {
    let pos = 1,
      gr = 0,
      sub_gr = "",
      str = "";

    $("table#sortable tbody tr").each(function (indx) {
      let type = $(this).attr("data-type");

      if (type == "group") {
        gr = gr == 0 ? pos : gr + 1;
        $("th:first", this).text(gr);
        pos = 1;
        sub_gr = "";
        return;
      }

      if (type == "subgroup") {
        let now_str = $("th:first", this).text();

        if (sub_gr.length == 0) {
          sub_gr = gr + "." + pos;
          pos = 1;
        } else if (now_str.length > sub_gr.length) {
          sub_gr = sub_gr + "." + pos;
          pos = 1;
        } else if (now_str.length < sub_gr.length) {
          let arr = sub_gr.split(".").slice(0, now_str.split(".").length);
          ++arr[arr.length - 1];
          sub_gr = arr.join(".");
          pos = 1;
        } else if (now_str.length == sub_gr.length) {
          let arr = sub_gr.split(".");
          ++arr[arr.length - 1];
          sub_gr = arr.join(".");
          pos = 1;
        }

        $("th:first", this).text(sub_gr);

        return;
      }

      if (type == "subject") {
        str = sub_gr == "" ? gr : sub_gr;
        $("th:first", this).text(gr == 0 ? pos : str + "." + pos);
        ++pos;
      }
    });
  }


  // ---- Contex Menu BEGIN

  $.contextMenu({
    selector: ".context-menu-one",
    trigger: "left",
    autoHide: true,
    callback: function (key, options) {
      var m = "clicked: " + key;
      (window.console && console.log(m)) || alert(m);
    },
    items: {
      name: {
        name: "Название",
        type: 'textarea',
        height: 50,
        disabled: function (key, opt) {
          // this references the trigger element
          return !this.data('nameDisabled');
        },
        events: {
          keyup: function (e) {
            if (e.keyCode==13) {
              let val_th =  e.data.$trigger.closest('th').find('span');
              val_th.text(this.value);
              e.data.$menu.trigger("contextmenu:hide");
            }
          }
        }
      },
      sep1: "---------",
      addGroup: { 
        name: "Добавить группу",
        icon: "add",
        visible: function (key, opt) {
          let dataType = opt.$trigger.closest('tr').attr('data-type');
          return dataType == 'group' ? true : false;
        },
      },
      addSubGroup: { name: "Добавить подгруппу",
        icon: "add",
        visible: function (key, opt) {
          let arr = ['group','subgroup'],
          dataType = opt.$trigger.closest('tr').attr('data-type');
          return arr.includes(dataType);
        },
      },
      addSubject: {
        name: "Добавить предмет",
        icon: "add",
        visible: function (key, opt) {
          let arr = ['group','subgroup'],
          dataType = opt.$trigger.closest('tr').attr('data-type');
          return arr.includes(dataType);
        },
      },
      editName: {
        name: "Изменить название",
        icon: "edit",
        callback: function () {
          this.data('nameDisabled', !this.data('nameDisabled'));
          return false;
        }
      },
      delete: {
        name: "Удалить",
        icon: "delete",
        callback: function(key, opt){
          if (confirm("Подтветдите удаление подгруппы?")) {
            opt.$trigger.closest('tr').remove();
            setTimeout(numberSort,300);
          }
        }
      },
    },
    events: {
      show: function(opt) {
          // this is the trigger element
          let $this = this,
          val_th =  $this.closest('th').find('span').text().trim();

          $.contextMenu.setInputValues(opt, {name:val_th});
          // this basically fills the input commands from an object
          // like {name: "foo", yesno: true, radio: "3", &hellip;}
      }, 
      hide: function(opt) {
          this.data('nameDisabled', false);
      }
    }
  });

  $(".context-menu-one").on("click", function (e) {
    // console.log("clicked", this);
  });

  // ---- Contex Menu END

  // --- Модальные окна BEGIN

  $("#order").on("click", function (event) {

    // let template = { '<>': 'input','type':'text', 'name':'vvod', 'value':'${title} ${year}' };
    let template = {"<>":"form","class":"form-inline","html":[
      {"<>":"div","class":"form-group mb-2","html":[
          {"<>":"label","for":"staticEmail2","class":"sr-only","html":"Email"},
          {"<>":"input","type":"text","readonly":"","class":"form-control-plaintext","id":"staticEmail2","value":"email@example.com","html":""}
        ]},
      {"<>":"div","class":"form-group mx-sm-3 mb-2","html":[
          {"<>":"label","for":"inputPassword2","class":"sr-only","html":"Password"},
          {"<>":"input","type":"password","class":"form-control","id":"inputPassword2","placeholder":"Password","html":""}
        ]},
      {"<>":"button","type":"submit","class":"btn btn-primary mb-2","html":"Сохранить"}
    ]};

    let data = [
      { "title": "Heat", "year": "1995" },
      { "title": "Snatch", "year": "2000" },
      { "title": "Up", "year": "2009" },
      { "title": "Unforgiven", "year": "1992" },
      { "title": "Amadeus", "year": "1984" }
    ];

    let html = json2html.transform({}, template);

    console.log(html);

    $('#myModal').modal({
      keyboard: false
    });

  });

  $('#myModal').on('hidden.coreui.modal', function (e) {
    console.log('hidden.coreui.modal');
  })
  // --- Модальные окна END

});
