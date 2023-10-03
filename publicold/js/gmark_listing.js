$(document).ready(function () {
  var _tokken = $('meta[name="_tokken"]').attr("content");
  var base_url = $("body").attr("data-url");
  $("#gmark_pagination").on("click", "a", function (e) {
    e.preventDefault();
    var pageno = $(this).attr("data-ci-pagination-page");
    loadPagination(pageno);
  });

  loadPagination(0);
  $(document).on("click", "#count_according", function () {
    loadPagination(0);
  });
  $(document).on("click", "#clear_count_according", function () {
    $("#count_type").val(1);
    $("#count_according_date_Type").val("report_release_date");
    $("#count_start").val("");
    $("#count_end").val("");
    loadPagination(0);
  });

  function loadPagination(pagno) {
   var applicant_id = ($(".applicant_id").val())?$(".applicant_id").val():'NULL';
    var start_date = $("#count_start").val() ? $("#count_start").val() : "NULL";
    var end_date = $("#count_end").val() ? $("#count_end").val() : "NULL";
    $.ajax({
      url: base_url + "Gmark/gmark_listing/"+applicant_id+"/NULL/NULL/NULL/" + pagno,
      type: "get",
      dataType: "json",
      success: function (response) {
        $("#gmark_pagination").html(response.pagination);
        createTable(response.result, response.row);
      },
    });
  }

  function createTable(result, sno) {
    sno = Number(sno);
    $("#gmark_list").empty();
    if (result) {
      $.each(result, function (key, value) {
        sno += 1;
        var tr = "<tr>";
        tr +=
          "<th scope='col'>" +
          sno +
          "</th><td>" +
          value.seq_no +
          "</td><td>" +
          value.application_name +
          "</td><td>" +
          value.certificate_no +
          "</td><td>" +
          value.test_report_no +
          "</td><td>" +
          value.applicant_name +
          "</td><td>" +
          value.manufacturer_name +
          "</td><td>" +
          value.factory_name +
          "</td><td>" +
          value.destination_name +
          "</td><td>" +
          value.lab_name +
          "</td><td>" +
          value.sub_lab_name +
          "</td><td>" +
          (value.status > 0 ? "ACTIVE" : "INACTIVE") +
          "</td><td>" +
          value.created_on +
          "</td><td></td>";
        tr += "</tr>";
        $("#gmark_list").append(tr);
      });
    } else {
      $("#gmark_pagination").append(
        '<tr><td align="center" colspan="4">NO RECORD FOUND</td></tr>'
      );
    }
  }

  $(document).on("keyup", ".applicant", function () {
    $.ajax({
      url: base_url + "Gmark/search",
      type: "POST",
      data: {
        key: $(this).val(),
        _tokken: _tokken,
        table: "gmark_customers",
        coloum: "entity_name",
        select: "customers_id,entity_name",
      },
      success: function (result) {
        var data = $.parseJSON(result);
        var html = "";
        if (data) {
          $.each(data, function (i, v) {
            html +=
              '<li class="list-group-item list-group-item-action li-state" data-id="' +
              v.customers_id +
              '">' +
              v.entity_name +
              "</li>";
          });
          html += "";
        }else{
            html += '<li class="list-group-item list-group-item-action li-state" data-id="NULL">NO RECORD FOUND</li>';
        }
        $("#itemList1").fadeIn();
        $(".applicant")
          .siblings("div.drop_down_ul.posiotio")
          .children("ul#itemList1")
          .html(html);
      },
      error: function (e) {
        console.log(e);
      },
    });
  });
  $("#itemList1").on("click", "li", function () {
    $(".applicant").val($(this).text());
    $(".applicant_id").val($(this).data("id"));
    $("#itemList1").fadeOut();
  });
  $(".applicant").focusout(function () {
    $("#itemList1").fadeOut();
  });
});
