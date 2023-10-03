$(document).ready(function () {
    const base_url = $("body").attr("data-url");
    const _tokken = $('meta[name="_tokken"]').attr("content");
    $(document).on('keyup', '.search-element input[type="search"]', function () {
        var text = $(this).val();
        if (text.length >= 2) {
            $.post(base_url+'GlobalSearch/index/'+btoa(text),{_tokken},setHtml,'json');
        }
    });
    
    function setHtml(data){
        $.each(data,function(i,v){
            $(`div[data-key="${i}"]`).html(v);
        });
    }
    $(document).on('click', '.goToSearchPage', function (e) {
        e.preventDefault();
        var controller = $(this).data('cont');
        var search_val = $(this).data('val');
        if (controller && search_val) {
            $.post(base_url+'GlobalSearch/setValue',{_tokken,controller:controller,search:search_val},PostSuccess,'json');
        }
    });
    function PostSuccess(data){
        location.href = base_url+data;
    }
})