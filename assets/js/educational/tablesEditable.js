$(function () {
  $("table#sortable tbody tr td").on("click", function (event) {
    
    // проверка текущего и оригинального значения
    function clearInput($td) {
      let dataHours = $td.attr("data-hours"),
        dataInput = $td.find('input[type="text"]:first').val();
      $td.removeClass();
      if (dataHours == dataInput) {
        $td.text(dataHours);  
      }
    }

    // let $td = $(this).find('td:eq(0)');
    let $td = $(this),
      OriginalContent = $td.text(),
      $td_prevActive = $td.closest("tbody").find("td.cell-active"),
      $tr_dataType = $td.closest("tr").attr("data-type");

    if ($tr_dataType == "group" || $tr_dataType == "subgroup") {
      return;
    }

    if ($td_prevActive.length) {
      clearInput($td_prevActive);
    }

    if ($td.find("input").length) {
      $td.addClass("cell-active");
      $td.find("input").focus();
      return;
    }

    $td.attr("data-hours", OriginalContent);
    $td.addClass("cell-active");
    $td.html("<input type='text' style='width: 100%;' value='" + OriginalContent + "' />");

    $td.children().first().focus();

    $td.children().first().keypress(function (e) {
        if (e.which == 13) {
          let newContent = $td.children().first().val();
          $td.attr("data-hours", newContent).text(newContent);
        }
      });

    // $td.children().first().blur(function () {
    //     $td.text(OriginalContent);
    // });

    // $td.find('input').click(function (e) {
    //     e.stopPropagation();
    // });
  });
});
