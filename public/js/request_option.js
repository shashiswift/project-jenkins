$(document).ready(function () {
    const base_url = $("body").data("url");
    const _tokken = $('meta[name="_tokken"]').attr("content");
    var pageno = 0;
    /* START CALL FUNCTION */
    get_applicant('client',null);
    /* END CALL FUNCTION */
    $(document).on("submit", ".request_option_form", function (e) {
      request_option_id = $('#request_option_id').val();
      if(request_option_id==""){
        url_  = base_url + "Request_option/add_request_option";
      }else{
        url_  = base_url + "Request_option/edit_req_option";
      }
      var self = $(this);
      e.preventDefault();
      $.ajax({ async:true,
        url: url_,
        type: "post",
        data: $(this).serialize(),
        success: function (data) {
          $('.req_form').remove();
          html = $.parseJSON(data);
          if (html.status > 0) {
            iziToast.success({
              title: "Success",
              message: html.msg,
              position: "topRight",
            });
            self.trigger("reset");
            $('#req_modal').modal('hide');
            loadPagination(pageno);
          } else {
            iziToast.warning({
              title: "Warning",
              message: html.msg,
              position: "topRight",
            });
          }
           if (html.errors) {
              var error = html.errors;
              $.each(error,function(i,v){
                $('#req_modal input[name="'+i+'"]').after('<span class="text-danger add_user_form">'+v+'</span>');
                $('#req_modal select[name="'+i+'"]').after('<span class="text-danger add_user_form">'+v+'</span>');
                $('#req_modal select[name="'+i+'"]').after('<span class="text-danger add_user_form">'+v+'</span>');
              });
            }
        },
        error: function (e) {
          console.log(e);
        },
      });
    });

  
    $(document).on("click", ".update_req", function (e) {
      var id = $(this).data("id");
      set_req_form(atob(id));
    });

    function set_req_form(id) {
      var id = id;
      $.ajax({ async:true,
        url: base_url + "Request_option/get_request_option",
        method: "POST",
        data: {
          _tokken: _tokken,
          request_option_id: id,
        },
        success: function (data) {
          var data = $.parseJSON(data);
          $("#request_option_id").val(data.request_option_id);
          get_applicant('client_list',data.customers_id);
          $("#quotes_recv_date").val(data.quotes_recv_date);
          $("#client_conf_date").val(data.client_conf_date);
          $("#charges_agreed").val(data.charges_agreed);
          $("#testing_req").val(data.testing_req);
          $("#testing_start_date").val(data.testing_start_date);
          $("#testing_end_date").val(data.testing_end_date);
          $("#doc_recv_date").val(data.doc_recv_date);
          $("#cert_sent_client").val(data.cert_sent_client);
          $("#draft_cert_conf_date").val(data.draft_cert_conf_date);
          $("#certificate_no").val(data.certificate_no);
          $("#date_registration_gso").val(data.date_registration_gso);
          $("#date_cert_upload_gso").val(data.date_cert_upload_gso);
          $("#date_cert_approval_gso").val(data.date_cert_approval_gso);
          $("#payment_status").val(data.payment_status);
          $("#remarks").html(data.remarks);
          getstatusEditName('editGsoStatus',data.gso_status);          
         
        },
        error: function (e) {
          console.log(e);
        },
      });
    }
  
  
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
      $("#listing_filter input").removeAttr('value');
      $("#listing_filter").trigger("reset");
      pageno = 0;
      loadPagination(pageno);
    });
  
    function loadPagination(pagno) {
      var client = $("#client_list").val()
        ? btoa($("#client_list").val())
        : "NULL";

      var search = $(".search").val() ? btoa($(".search").val()) : "NULL";
      $.ajax({ async:true,
        url:
          base_url +
          "Request_option/req_option_listing/" +
          client +
          "/" +
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
   


    $("#add_request_btn").click(function(){
      $('.request_option_form').trigger("reset");
      $('#request_option_id').removeAttr('value');
      get_applicant('client_list',null);
    });

    getstatusEditName('gso_status');
    

    function getstatusEditName(selectBox,id = null){
     let _element = $('select.'+selectBox);
      $.ajax({
        url: base_url + "Request_option/gso_statusList",
        method: "GET",
        success:function(res){
          var data = $.parseJSON(res);
          _element.html("");
          _element.append("<option value=''>Choose Status</option>");
          if(data){
            var op ="";
            $.each(data,function(index,value){
              
              if(id!=null){
                if(id == value.id){
                  op += "<option value="+value.id+" selected>"+value.name+"</option>";
                } 
                else{
                  op += "<option value="+value.id+">"+value.name+"</option>";
                }
              }
              else{
                op += "<option value="+value.id+">"+value.name+"</option>";
              }  
            })
            _element.append(op);
          }
        }
      });
    }
    
    function get_applicant(selectBox,applicant_id = null){
     let _element = $('select.'+selectBox);
      $.ajax({
        url: base_url + "Request_option/get_applicant",
        method: "GET",
        success:function(res){
          var data = $.parseJSON(res);
          _element.html("");
          _element.append("<option value=''>Choose Client</option>");
          if(data){
            var op ="";
            $.each(data,function(index,value){
              
              if(applicant_id!=null){
                if(applicant_id == value.id){
                  op += "<option value="+value.id+" selected>"+value.name+"</option>";
                } 
                else{
                  op += "<option value="+value.id+">"+value.name+"</option>";
                }
              }
              else{
                op += "<option value="+value.id+">"+value.name+"</option>";
              }  
            })
            _element.append(op);
          }
        }
      });
    }
  
  
  });
  