$(document).ready(function(){

    //$('#searchInput').val('');

    $('#parent_name').blur(function(){
        if(!flagSelectParentName) {
            $('#parent_name').val('');
        }
    });

    $('#resetParam').click(function(e){
        e.preventDefault();
        $('#searchInput').val('');
        $('thead.thead-light i.fa.fa-fw').attr('class', 'fa fa-fw fa-sort');
        getStaffsList(1);
    })

    $('body').on('submit', '#staffSearchForm', function(e) {
        e.preventDefault();

        $('#searchInput').prop('required', false);
        getStaffsList(1);
    });

    $('body').on('click', '.table thead.thead-light a', function(e) {
        e.preventDefault();

        var arrow = $(this).parent().find('i.fa.fa-fw');
        if(arrow.hasClass('fa-sort')){
            $('thead.thead-light i.fa.fa-fw').attr('class', 'fa fa-fw fa-sort');
            $(arrow).removeClass('fa-sort');
            $(arrow).addClass('fa-sort-asc');
        }
        else if(arrow.hasClass('fa-sort-asc')){
            $(arrow).removeClass('fa-sort-asc');
            $(arrow).addClass('fa-sort-desc');
        }
        else {
            $(arrow).removeClass('fa-sort-desc');
            $(arrow).addClass('fa-sort-asc');
        }

        var pageNum = getActivePaginNum();
        getStaffsList(pageNum);
    });

    $('body').on('click', '.pagination a.page-link', function(e) {
        e.preventDefault();
        var pageNum = $(this).attr('href').split('page=')[1];
        getStaffsList(pageNum);
    });


    if($('.alert.alert-success').length > 0){
        setTimeout(function() {
            $('.alert.alert-success').fadeOut();
        },5000);
    }

    $("#avatarInput").change(function(){
        readURL(this);
    });

    staffsSearch();

    $("body").on("click", '.usersTree li span.haveChild', function () {
        uploadStaffsSubTree($(this));
    });


    $(function () {
        var oldParentId;
        var oldContainer;
        $("ul.draggable").sortable({
            group: 'nested',
            onDragStart: function ($item, container, _super, event) {
                oldParentId = $item.parent().attr('data-parent-id');
                $item.css({
                    height: $item.outerHeight(),
                    width: $item.outerWidth()
                });
                $item.addClass(container.group.options.draggedClass);
                $("body").addClass(container.group.options.bodyClass);
            },
            onDrop: function ($item, container, _super) {
                container.el.removeClass("active");
                _super($item, container);
                var elemId = $item.find('span').attr('data-id');
                var newParentId = $item.parent().attr('data-parent-id');
                if(newParentId != oldParentId){
                    changeStaffBoss($item, elemId, newParentId);
                }
            },
            isValidTarget: function($item, container){
                if(container.el.attr('data-parent-id') == $item.find('span').attr('data-id')){}
                else return true;
            }
        });
    });

});


function changeStaffBoss(obj, elemId, newParentId){
    $('.preloader').fadeIn();
    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: '/staff_change_parent',
        data: {
            elem_id: elemId,
            new_parent_id: newParentId
        },
        success: function(responce) {
            $('.preloader').fadeOut();
            if(obj.parent().parent().children('span.haveChild').length > 0){
               obj.remove();
                //uploadStaffsSubTree(obj.parent().parent().find('span.haveChild'));
            }
        },
        error: function(){
            alert('Что то пошло не так, обратитесь к администратору.');
            $('.preloader').fadeOut();
        }
    })
}



function getActivePaginNum(){
    var num = $('.pagination li.active span.page-link').html();
    num = parseInt(num);
    if(isNaN(num)) num = 1;
    return num;
}


function getStaffsList(pageNum) {
    $('.preloader').fadeIn();
    var sortVal = 1;
    var sortName = '';
    var sortParamString = '';
    var searchText = $.trim($('#searchInput').val());

    if($('thead.thead-light i.fa-sort-asc').length > 0){
        sortVal = 1;
        sortName = $('thead.thead-light i.fa-sort-asc').attr('data-sort');
    }
    else if($('thead.thead-light i.fa-sort-desc').length > 0){
        sortVal = 0;
        sortName = $('thead.thead-light i.fa-sort-desc').attr('data-sort');
    }

    if(sortName != ''){
        var sortParam = {};
        sortParam[sortName] = sortVal;
        sortParamString += '&sort['+sortName+']='+sortVal
    }

    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: '/staffs',
        data: {
                search: searchText,
                sort: sortParam,
                page: pageNum,
        },
        success: function(responce) {
            $('#table_block').html(responce);

            var paramString = getUrlParam(searchText, sortParamString, pageNum);
            window.history.pushState('1', '', paramString);
            $('.preloader').fadeOut();
        },
        error: function(){
            alert('Что то пошло не так, обратитесь к администратору.');
            $('.preloader').fadeOut();
        }
    })
}


function getUrlParam(searchText, sortParamString, pageNum){
    var paramString = '?';
    if(sortParamString != '') paramString += sortParamString;
    if(searchText != '') paramString += '&search='+searchText;
    paramString += '&page='+pageNum;

    return paramString;
}


var flagSelectParentName = 0;
function staffsSearch(){
    $('#parent_name').autocomplete({
        source: function(request, response){
            flagSelectParentName = 0;
            $.ajax({
                type: 'GET',
                url : "/staffs_search",
                dataType : "json",
                data:{
                    nameStartsWith: request.term
                },
                success: function(data){
                    response($.map(data, function(item){
                        return {
                            id: item.id,
                            value: item.full_name
                        }
                    }));
                }
            });
        },
        delay: 0,
        minLength: 3,
        select: function( event, ui ) {
            flagSelectParentName = 1;
            $('#parent_name').val(ui.item.value);
            $('#parent_id').val(ui.item.id);
        }

    });
}



function uploadStaffsSubTree(obj) {
    $('.preloader').fadeIn();
    var rootStaffId = obj.attr('data-id');
    $.ajax({
        type: 'GET',
        datatype: 'json',
        url: '/',
        data: {
            parent_staff_id: rootStaffId
        },
        success: function(responce) {
            obj.removeClass('haveChild');
            //obj.parent().find('ul').remove();
            //$(obj).after(responce);

            obj.parent().find('ul').html($(responce).children());
            $('.preloader').fadeOut();


        },
        error: function(){
            alert('Что то пошло не так, обратитесь к администратору.');
            $('.preloader').fadeOut();
        }
    })
}


function readURL(input) {

    if (input.files && input.files[0]) {
        validateFile(input);

        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageAvatar').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}


function validateFile(fileInput){

    var fileObj, size;
    if ( typeof ActiveXObject == "function" ) { // IE
        fileObj = (new ActiveXObject("Scripting.FileSystemObject")).getFile(fileInput.value);
    }else {
        fileObj = fileInput.files[0];
    }

    size = fileObj.size; // Size returned in bytes.
    if(size > 3 * 1024 * 1024){//3Mb
        $(fileInput).parent().find(".jq-file__name").html("");
        $(fileInput).parent().removeClass('changed');
        $("#avatarInput").val('');
        alert('Выбранный файл слишком велик. Загрузите файл размером до 3 MB.')
        return false;
    }
    else {
        $(fileInput).parent().parent().parent().find(".main.error.size").remove();
    }

    var filesExt = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG']; // массив расширений
    var parts = $(fileInput).val().split('.');
    if(filesExt.join().search(parts[parts.length - 1]) != -1){}
    else {
        $(fileInput).parent().find(".jq-file__name").html("");
        $(fileInput).parent().removeClass('changed');
        $("#avatarInput").val('');
        alert('Недопустимый формат файла.')
        return false;
    }

    return true;
}



