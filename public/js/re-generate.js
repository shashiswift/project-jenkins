$(document).ready(function () {
  var _tokken = $('meta[name="_tokken"]').attr("content");
  var base_url = $("body").attr("data-url");
  var pageno = 0;

  $("#gmark_pagination").on("click", "a", function (e) {
    e.preventDefault();
    pageno = $(this).attr("data-ci-pagination-page");
    loadPagination(pageno);
  });

  loadPagination(0);
  $(document).on("click", ".submit_listing", function () {
    pageno = 0;
    loadPagination(pageno);
  });
  $(document).on("click", ".clear_listing", function () {
    $("input").val("");
    $("#listing_filter").trigger("reset");
    loadPagination(0);
  });

  function loadPagination(pagno) {
    var applicant_id = $(".applicant_id").val()
      ? $(".applicant_id").val()
      : "NULL";
    var manufacture_id = $(".manufacture_id").val()
      ? $(".manufacture_id").val()
      : "NULL";
    var factory_id = $(".factory_id").val() ? $(".factory_id").val() : "NULL";
    var lab_name = $(".lab_name").val() ? $(".lab_name").val() : "NULL";
    var start_Date = $(".start_Date").val() ? $(".start_Date").val() : "NULL";
    var end_Date = $(".end_Date").val() ? $(".end_Date").val() : "NULL";
    var destinaition = $(".destinaition").val()
      ? $(".destinaition").val()
      : "NULL";
    var application = $(".application").val()
      ? $(".application").val()
      : "NULL";
    var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
    $.ajax({
      async: true,
      url:
        base_url +
        "Regenerate/re_generate_listing/" +
      search +
        "/" +
        pagno,
      type: "get",
      dataType: "json",
      success: function (response) {
        $("#gmark_pagination").html(response.pagination);
        // console.log(response.result);
        createTable(response.result);
      },
    });
  }

  function createTable(result) {
    $("#gmark_list").empty();
    $("#gmark_list").html(result);
  }
  $(document).on('click','.approved_request',function(){
    var id = $(this).data('id');
    swal({
      title: "Are you sure?",
      text:
        "Once APPROVED, you will not be able to REJECT THIS RE-GENERATE REQUEST  !",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((APPROVED) => {
      if (APPROVED) {
        $('body').append('<div class="pageloader"></div>');
        $.ajax({
          async:true,
          url: base_url + "Regenerate/approved",
          type: "post",
          data: { id: id, _tokken: _tokken },
          success: function (data) {
            $('.pageloader').remove();
            var data = $.parseJSON(data);
            if (data.status > 0) {
              swal(" Your RE-GENERATE REQUEST has been APPROVED!", {
                icon: "success",
              });
              iziToast.success({
                title: "success",
                message: data.msg,
                position: "topRight",
              });
              loadPagination(pageno);
            } else {
              iziToast.warning({
                title: "ERROR",
                message: data.msg,
                position: "topRight",
              });
            }
          },
          error: function (e) {
            $('.pageloader').remove();
            console.log(e);
          },
        });
      } else {
        swal("YOU CANCEL TO CHANGE ANYTHING!");
      }
    });
  });
  $(document).on('click','.reject_request',function(){
    var id = $(this).data('id');
    swal({
      title: "Are you sure?",
      text:
        "Once REJECT, you will not be able to APPROVED THIS RE-GENERATE REQUEST  !",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((REJECT) => {
      if (REJECT) {
        $('body').append('<div class="pageloader"></div>');
        $.ajax({
          async:true,
          url: base_url + "Regenerate/reject",
          type: "post",
          data: { id: id, _tokken: _tokken },
          success: function (data) {
            $('.pageloader').remove();
            var data = $.parseJSON(data);
            if (data.status > 0) {
              swal(" Your RE-GENERATE REQUEST has been reject!", {
                icon: "success",
              });
              iziToast.success({
                title: "success",
                message: data.msg,
                position: "topRight",
              });
              loadPagination(pageno);
            } else {
              iziToast.warning({
                title: "ERROR",
                message: data.msg,
                position: "topRight",
              });
            }
          },
          error: function (e) {
            $('.pageloader').remove();
            console.log(e);
          },
        });
      } else {
        swal("YOU CANCEL TO CHANGE ANYTHING!");
      }
    });
  });

});
