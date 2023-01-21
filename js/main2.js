let errors = [];
let idComm = "";
let cts = $('#footer-cat').children();
let objCats = [];

for(i of cts){
    objCats.push({id: i.getAttribute('data-id'), name: i.text});
}
function ajaxCallback(page, method, data, result){
    $.ajax({
      url: `${page}.php`,
      method: method,
      dataType: "json",
      data: data,
      success: result,
      error: (xhr, exception) =>{
          var errorMessage = '';
          if (xhr.status === 0){
              errorMessage = 'You are not connected, please check your internet connection';
          }
          else if(xhr.status == 404){
              errorMessage = 'Error 404 page not found.';
          } 
          else if(xhr.status == 500){
              errorMessage = 'Error 500 internal server error';
          } 
          else if(exception === 'parsererror'){
              errorMessage = 'JSON parse failed';
          } 
          else if(exception === 'timeout'){
              errorMessage = 'Time out error.';
          } 
          else if(exception === 'abort'){
              errorMessage = 'Ajax request aborted.';
          } 
          else{
              errorMessage = 'Uncaught Error.\n' + xhr.responseText;
          }
          alert(errorMessage);
          console.log(xhr)

      }
    })
}
$(document).ready(function(){
    $('body').on('click','.replyComment',function(){
        $('#leave-reply').text("Reply");
        $('#comment').focus();
        idComm = $(this).parent().parent().find('input[type=hidden]').val();
    });
    $('body').on('click','.nc-delete',function(){
        let send = {
            id: $(this).parent().find('input[type=hidden]').val(),
            btn: true
        }
        ajaxCallback("models/delete-comment", "post", send, result=>{
        });
    });
    $('body').on('change','.status',function(){
        let send = {
            id: $(this).parent().parent().find('input[type=hidden]').val(),
            dataValue: $("option:selected", this).val(),
            column: $(this).data('type'),
            btn: true
        }
        ajaxCallback("models/admin", "post", send, result=>{
        });
    });
    $(document).on('click', '.news-pagination', function(elem){
        elem.preventDefault();
        let limit = $(this).data('limit');
        filterChange(limit);
    });
    $(document).on('click', '.category-btn', function(elem){
        elem.preventDefault();
        let view = $(this).data('view');
        localStorage.setItem("view", JSON.stringify(view));
        location.href = "index.php?page=all-news";
    });
    let url = window.location.href;
    url = url.slice(url.indexOf('=')+1, url.length);
    if(url == "index" || url == "/" || url.indexOf("index")!= -1){
        $("nav a[href='index.php?page=index']").addClass("active");
    }
    else if(url == "category"){
        $("nav a[href='index.php?page=category']").addClass("active");
    }
    else if(url.indexOf("login") != -1){
        $("#login").click(function(){
            formCheck($("#email").val(), /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/, "email", "Please enter your email ex. email@gmail.com");
            formCheck($("#password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "password", "Password length has to be at least 6, and it has to have at least one number and no special characters");
            if(errors.length == 0){
                let send = {
                    email: $("#email").val(),
                    password: $("#password").val(),
                    btnl: true
                }
                ajaxCallback("models/login", "post", send, result=>{
                    serverCheck(result.email ,"email");
                    serverCheck(result.passLog ,"password");      
                    if(typeof(result) == "string"){
                        $('#login').after(`<p class='text-success mt-3'>${result}</p>`);
                        setTimeout(function(){
                            window.location.replace("index.php");
                        }, 1000);
                    }
                });
            }
        });
    }
    else if(url == "registration"){
        $("#register").click(function(){
            formCheck($("#name").val(), /^[A-Z][a-z]{2,15}$/, "name", "Please enter your name ex. David");
            formCheck($("#lastName").val(), /^[A-Z][a-z]{2,15}(\s([A-Z][a-z]{2,15})){0,3}$/, "lastName", "Please enter your last name ex. James");
            formCheck($("#email").val(), /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/, "email", "Please enter your email ex. email@gmail.com");
            formCheck($("#password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "password", "Password length has to be at least 6, and it has to have at least one number and no special characters");
            formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password", "Password do not match");
            if(errors.length == 0){
                $(this).after("<p>Please wait a second</p>")
                let send = {
                    name: $("#name").val(),
                    lastName: $("#lastName").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    btn: true
                }
                ajaxCallback("models/registration2", "post", send, result=>{
                    serverCheck(result.name ,"name");
                    serverCheck(result.lastName ,"lastName");
                    serverCheck(result.email ,"email");
                    serverCheck(result.password ,"password");
                    formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password");
                    if(typeof(result) == "string" && formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password")){
                        $('#model').append(`<div class="modal fade" id="successful-registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">${result}</h5>
                            </div>
                            <div class="modal-body">
                                You have successefuly logged in, thank you for joining
                            </div>
                            <div class="modal-footer">
                              <a href="index.php" class="btn btn-primary">Ok let's go</a>
                            </div>
                          </div>
                        </div>
                      </div>`);
                      $('#successful-registration').modal('show');
                    }
                });
            }
        });
    }
    else if(url.indexOf("single") != -1){
        setInterval(function(){
            $("#reloadDiv").load(location.href + " #rld");
        }, 1000);
        $('#postComment').click(commFunction);
        $('#deleteNew').click(function(){
            let send = {
                id: $('#idNew').val(),
                img: $(this).data('img'),
                src: $(this).data('src'),
                btn: true
            }
            ajaxCallback("models/delete-new", "post", send, result=>{
                if(result != ""){
                    $('#single-modal').append(`<div class="modal fade" id="delete-new-mdl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">${result}</h5>
                        </div>
                        <div class="modal-body">
                            New deleted
                        </div>
                        <div class="modal-footer">
                          <a href="index.php" class="btn btn-primary">OK go</a>
                        </div>
                      </div>
                    </div>
                  </div>`);
                  $('#delete-new-mdl').modal('show');
                }
            });
        });
    }
    else if(url == "contact"){
        $("nav a[href='index.php?page=contact']").addClass("active");
        $('#btnContactMessage').click(function(){
            formCheck($('#contactName').val(), /^[A-Z][a-z]{2,15}$/, "contactName", "Please enter your name ex. David");
            formCheck($("#contactEmail").val(), /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/, "contactEmail", "Please enter your email ex. email@gmail.com");
            formCheck($("#contactMessage").val(), /^([\w\.\-\s]{10,150})+$/, "contactMessage", "Message should have at least 10 characters");
            if(errors.length == 0){
                let send = {
                    name: $("#contactName").val(),
                    email: $("#contactEmail").val(),
                    message: $("#contactMessage").val(),
                    btn: true
                }
                ajaxCallback("models/messages", "post", send, result=>{
                    serverCheck(result.name ,"contactName");
                    serverCheck(result.email ,"contactEmail");
                    serverCheck(result.message ,"contactMessage");
                    if(typeof(result) == "string"){
                        $('#form-contact').trigger("reset");
                        $('#contactMessage').after(`<p class='help-block text-success' id='pass'>${result}</p>`);
                    }
                });
            }
        });
    }
    else if(url.indexOf("all-news") != -1){
        let cat = 0;
        if(JSON.parse(localStorage.getItem("view")) != null){
            cat = JSON.parse(localStorage.getItem("view"));
        }
        localStorage.removeItem("view");
        let send = {
            limit: 0,
            category: cat,
            btn: true
        }
        try{
            ajaxCallback("models/pagination", "get", send, result=>{
                console.log("vration");
                console.log(result);
                printNews(result.news, result.dates);
                printPagination(result.pages);
            });
        }
        catch(error){
            console.log(error);
        }
        console.log("tu je");
        $(`#filterNews option[value=${cat}]`).attr('selected', 'selected');
        $("nav a[href='index.php?page=all-news']").addClass("active");
    }
});
$('#add-survey-btn').click(function(){
    if(!$('#add-more').is(':visible')){
        $(this).next().after("<p class='text-primary' id='add-more'>Add more</p>");
        $('#add-more').after("<input type='button' value='Done' class='btn btn-success' id='send-survey' />")
    }
    $(this).next().after(`<input type="text" class="form-control w-50 surv-respones mt-3" placeholder="Response" />`);
    $(this).off();
    $('#add-more').click(function(){
        $(this).before(`<input type="text" class="form-control w-50 surv-respones mt-3" placeholder="Response" />`);
    });
    $('#send-survey').click(function(){
        let question = $('#add-survey').val();
        let respones = [];
        $('.surv-respones').each(function(){
            if($(this).val().trim() != ""){
                respones.push($(this).val());
            }
        });
        formCheck(question, /^\w/, "add-survey", "Please enter question");
        if(respones.length < 2){
            $('.surv-respones').last().attr('id', 'last-res');
            formCheck("false", "true", "last-res", "You have to enter at least two responses.");
            return;
        }
        formCheck("true", "true", "last-res", "You have to enter at least two responses.");
        if(errors.length == 0){
            let send = {
                question: question,
                respones: respones,
                btn: true
            }
            ajaxCallback("models/add-survey", "post", send, result=>{
                location.reload();
            });
        }
    });
});
$('.cb-survey').change(function(){
    if($(this).is(':checked')){
        var status = 1;
    }
    else{
        var status = 0;
    }
    let send = {
        id: $(this).parent().parent().parent().data('id'),
        status: status,
        btn: true
    }
    ajaxCallback("models/survey-status", "post", send, result=>{
    });
});
$('#editNew').click(function(){
    let title = $(this).next();
    let content = $(this).next().next();
    let cat = $(this).prev().prev().prev();
    $(cat).remove();
    $(title).remove();
    $(content).remove();
    $(this).parent().children().first().before(makeSelect(objCats, $(cat).data('cat')));
    $(this).after(`<input type="button" class="btn btn-sm btn-success rounded mt-3" id="finish-edit-new" value="Done" />`);
    $(this).after(`<textarea cols="30" rows="15" class="form-control mt-3" id="txt-content">${$(content).text()}</textarea>`);
    $(this).after(`<textarea cols="30" rows="3" class="form-control mt-3" id="txt-title">${$(title).text()}</textarea>`);

    $('#finish-edit-new').click(function(){
        let newTitle = $('#txt-title').val();
        let newContent = $('#txt-content').val();
        let newCat = $('#edit-new-category option:selected').val();
        formCheck(newTitle, /^([\w\.\-\s\!\?\,\(\)\"\'\:\;\@]){10,80}$/, "txt-title", "Title must have between 10 and 80 characters");
        formCheck(newContent, /^([\w\.\-\s\!\?\,\(\)\"\'\:\;\@]){30,}$/, "txt-content", "Content should have at least 30 characters");
        formCheck(newCat, /^[1-9]\d*$/, "edit-new-category", "Don't try to break this website, you are not smarter than me ;)");
        if(errors.length == 0){
            let send = {
                idNew: $('#idNew').val(),
                category: newCat,
                title: newTitle,
                content: newContent,
                btn: true
            }
            ajaxCallback("models/edit-new", "post", send, result=>{
                serverCheck(result.title, "txt-title");
                serverCheck(result.content, "txt-content");
                serverCheck(result.category, "edit-new-category");
                if(result == true){
                    location.reload();
                }
            });
        }
    });
});
let regCat = /^([A-Z][a-z]{2,15}){1,5}(\s[A-Z]{0,2}[a-z]{2,15}){0,4}$/;
$('#add-category').click(function(){
    errors = [];
    let nameCat = $("#add-category-text").val();
    formCheck(nameCat, regCat, "add-category-text", "Category must start with capital and have no nubers");
    if(errors.length == 0){
        let send = {
            nameCat: nameCat,
            btn: true
        }
        ajaxCallback("models/add-category", "post", send, result=>{
            serverCheck(result.nameCat , "add-category-text");
            if(result == true){
                location.reload();
            }
        });
    }
});
$('.edit-category').click(function(){
    errors = [];
    let edit = $(this).parent().prev().children().first().val();
    formCheck(edit, regCat, $(this).parent().prev().children().first().attr('id'), "Category must start with capital and have no nubers");
    if(errors.length == 0){
        let send = {
            id: $(this).parent().parent().parent().parent().data('id'),
            edit: edit,
            btn: true
        }
        ajaxCallback("models/edit-category", "post", send, result=>{
            serverCheck(result.edit , $(this).parent().prev().children().first().attr('id'));
            if(result == true){
                location.reload();
            }
        });
    }
});
$('.delete-category').click(function(){
    let send = {
        id: $(this).parent().parent().data('id'),
        btn: true
    }
    ajaxCallback("models/delete-category", "post", send, result=>{
        serverCheck(result.news , $(this).parent().parent().attr('id'));
        if(result == true){
            location.reload();
        }
    });
});
$('#ptp').one('click', function(){
    $(this).after(`<input type="password" class="form-control" id="password" placeholder="Change password" /><input type="password" class="form-control mt-3" id="conf-password" placeholder="Confirm password" /><input type="button" class="btn btn-primary mt-3" value="Change" id="cpassBtn" /><p class="mt-2">Note: if you change your password you will be logged out</p>`);
    $('#cpassBtn').click(function(){
        formCheck($("#password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "password", "Password length has to be at least 6, and it has to have at least one number and no special characters");
        formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password", "Password do not match");
        if(errors.length == 0){
            let send = {
                id: $('#ptp').data('id'),
                password: $('#password').val(),
                btn: true
            }
            ajaxCallback("models/change-password", "post", send, result=>{
                serverCheck(result.password ,"password");
                if(result != ""){
                    $('#cpassBtn').after(`<p class='text-success mt-3'>${result}</p>`);
                    setTimeout(function(){
                        window.location.replace("models/sign-out.php?id=1");
                    }, 1500);
                }
            });
        }
    });
});
$('.send-response').click(function(){
    let mainClass = $(this).prev().children();
    let name = $(mainClass).first().attr('name');
    let response = $(`input[name=${name}]:checked`).val();
    let survey = $(this).data('survey');
    if(response == undefined){
        if($(`#surr-error${survey}`).is(':visible')) return;
        $(mainClass).last().after(`<p id='surr-error${survey}' class='text-danger'>Please select response</p>`);
        return;
    }
    let send = {
        survey: $(this).data('survey'),
        response: response,
        btn: true
    }
    ajaxCallback("models/post-survey", "post", send, result=>{
        if(result != true){
            $(mainClass).last().after(`<p id='surr-error-server${survey}' class='text-danger'>${result.response}</p>`);
            return;
        }  
        location.reload();
    });
});
$('.nc-delete-survey').click(function(){
    let send = {
        id: $(this).parent().parent().data('id'),
        btn: true
    }
    ajaxCallback("models/delete-survey", "post", send, result=>{
        if(result == true){
            location.reload();
        }
    });
});
$('.nc-delete-message').click(function(){
    let send = {
        id: $(this).data('id'),
        btn: true
    }
    ajaxCallback("models/delete-message", "post", send, result=>{
        if(result == true){
            location.reload();
        }
    });
});
$('#filterNews').change(function(){
    filterChange();
});
$('#orderNews').change(function(){
    filterChange();
});
function printNews(news, dates, limit){
    let html = "";
    let rb = limit * 2 + 1;
    var i = 0;
    for(n of news){
        html += `<div class="col-lg-12">
                    <div class="row news-lg mx-0 mb-3">
                        <div class="col-md-6 h-100 px-0">
                            <img class="img-fluid h-100" src="img/${n.src}" alt="${n.alt}" style="object-fit: cover;">
                        </div>
                        <div class="col-md-6 d-flex flex-column border bg-white h-100 px-0">
                            <div class="mt-auto p-4">
                                <div class="mb-2">
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2 category-btn" data-view="${n.category_id}" href="#">
                                        ${n.name}
                                    </a>
                                    <p class="text-body mb-0"><small>${dates[i]}</small></p>
                                </div>
                                <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="index.php?page=single&single=${n.news_id}">
                                    ${n.title.length > 15 ? n.title.substring(0,15)+"..." : n.title}                                              
                                </a>
                                <p class="m-0">
                                    ${n.content.length > 130 ? n.content.substring(0,130)+"..." : n.content}                                                      
                                </p>
                            </div>
                            <div class="d-flex justify-content-between bg-white border-top mt-auto p-4">
                                <div class="d-flex align-items-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        rb++;   
        i++;     
    }
    $('#insert-news').html(html);
}
function nemanja(){
    return "retu";
}
function getComments(id){
    let number = "";
    let send = {
        id: id,
        btn: true
    }
    ajaxCallback("models/number-comments", "post", send, result=>{
        if(!isNaN(result)){
            number = result.toString();
        }  
    });
    return number;
}
function printPagination(numberOfPages){
    html = "";
    for(let i = 0; i < numberOfPages / 4; i++){
        html += `
        <li class="page-item">
            <a class="page-link news-pagination" href="#" data-limit="${i}">${(i+1)}</a>
        </li>`
    }
    $("#pagination-page").html(html);
}
function filterChange(limit = 0){
    let category = $('#filterNews option:selected').val();
    let sorting = $('#orderNews option:selected').val();    
    let send = {
        limit: limit,
        category: category,
        sort: sorting,
        btn: true
    };
    try{
        ajaxCallback("models/pagination", "get", send, result=>{
            printNews(result.news, result.dates);
            printPagination(result.pages);
        });
    }
    catch(error){
        console.log(error);
    }
}
function makeSelect(data, idc){
    let html = "<select id='edit-new-category' class='form-select form-select-sm' data-type='active' aria-label='.form-select-sm example'>";
    for(i of data){
        html += `<option value=${i.id} ${idc == i.id ? "selected" : ""}>${i.name}</>`;
    }
    html += "</select>";
    return html;
}
function commFunction(){
    if($('#comment').val().trim() != ""){
                if($(`#message-comment`).is(":visible")){
                    $(`#message-comment`).remove();
                    $('#comment').removeClass("border border-danger");
                }
                let send = {
                    comment: $('#comment').val(),
                    idUser: $('#idUser').val(),
                    idNew: $('#idNew').val(),
                    btn: true
                }
                if(idComm != ""){
                    send.idComment = idComm;
                    idComm = "";
                }
                ajaxCallback("models/post-comment", "post", send, result=>{
                    if(result.comment == undefined){
                        $('#leave-reply').text("Leave a comment");
                        $('#comment').val("");
                        $('#comment').after(`<p class='text-success' id='comment-message'>${result}</p>`);
                        setTimeout(function(){
                            $("#comment-message").remove();
                        }, 2000);
                    }
                    else{
                        serverCheck(result.comment ,"comment");
                    }
                });
            }
            else{
                $('#comment').addClass("border border-danger").after("<p class='text-danger' id='message-comment'>Please enter comment</p>");
            }
}
function serverCheck(data, id){
    if(data != undefined){
        if(id == "email"){
            $(`#message-${id}`).remove();
        }
        if(id == "password"){
            $(`#message-${id}`).remove();
        }
        if($(`#message-${id}`).is(":visible")) return;
        $(`#${id}`).addClass('border border-danger').after(`<p class='help-block text-danger mb-0' id='message-${id}'>${data}</p>`);
    } 
    else{
        formCheck("true", "true", id, "m");
    }
}
function formCheck(val, reg, id, message){
    if(val.match(reg)){
        if(id == "conf-password"){
            if($('#password').val() != val){
                if($(`#message-conf-password`).is(":visible")) return;
                $('#conf-password').addClass('border border-danger').after(`<p class='text-danger mb-0' id='message-conf-password'>${message}</p>`);
                errors.push(id);
                return;
            }
        }
        $(`#message-${id}`).fadeOut();
        $(`#${id}`).removeClass("border border-danger");
        errors = errors.filter(el=>el != id);
        return true;
    }
    else if(id == "conf-password") {
        if($(`#message-${id}`).is(":visible")) return;
        $(`#${id}`).after(`<p class='text-danger mb-0' id='message-${id}'>${message}</p>`).addClass('border border-danger');
        errors.push(id);
    }
    else{  
        $('#pass').fadeOut();
        errors.push(id);
        if($(`#message-${id}`).is(":visible")) return;
        $(`#${id}`).after(`<p class='help-block text-danger mb-0' id='message-${id}'>${message}</p>`);
        if(id.indexOf("id-") != -1) return;
        $(`#${id}`).addClass("border border-danger");
    }
}
