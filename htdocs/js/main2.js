let errors = [];
let idComm = "";
function ajaxCallback(page, data, result){
    $.ajax({
      url: `${page}.php`,
      method: "post",
      dataType: "json",
      data: data,
      success: result,
      error: (xhr, exception) =>{
        console.log(xhr);
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
        ajaxCallback("models/delete-comment", send, result=>{
        });
    });
    $('body').on('change','.status',function(){
        let send = {
            id: $(this).parent().parent().find('input[type=hidden]').val(),
            dataValue: $("option:selected", this).val(),
            column: $(this).data('type'),
            btn: true
        }
        ajaxCallback("models/admin", send, result=>{
        });
    });
    let url = window.location.pathname;
    if(url == "/index.php" || url == "/"){
        $("nav a[href='index.php']").addClass("active");
    }
    else if(url == "/category.php"){
        $("nav a[href='category.php']").addClass("active");
    }
    else if(url == "/login.php"){
        $("#login").click(function(){
            formCheck($("#email").val(), /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/, "email", "Please enter your email ex. email@gmail.com");
            formCheck($("#password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "password", "Password length has to be at least 6, and it has to have at least one number and no special characters");
            if(errors.length == 0){
                let send = {
                    email: $("#email").val(),
                    password: $("#password").val(),
                    btnl: true
                }
                ajaxCallback("models/login", send, result=>{
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
    else if(url == "/registration.php"){
        $("#register").click(function(){
            formCheck($("#name").val(), /^[A-Z][a-z]{2,15}$/, "name", "Please enter your name ex. David");
            formCheck($("#lastName").val(), /^[A-Z][a-z]{2,15}(\s([A-Z][a-z]{2,15})){0,3}$/, "lastName", "Please enter your last name ex. James");
            formCheck($("#email").val(), /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/, "email", "Please enter your email ex. email@gmail.com");
            formCheck($("#password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "password", "Password length has to be at least 6, and it has to have at least one number and no special characters");
            formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password", "Password do not match");
            if(errors.length == 0){
                let send = {
                    name: $("#name").val(),
                    lastName: $("#lastName").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    btn: true
                }
                ajaxCallback("models/registration2", send, result=>{
                    serverCheck(result.name ,"name");
                    serverCheck(result.lastName ,"lastName");
                    serverCheck(result.email ,"email");
                    serverCheck(result.password ,"password");
                    formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password");
                    if(typeof(result) == "string" && formCheck($("#conf-password").val(), /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\s]{6,}$/, "conf-password")){
                        $('#model').append(`<div class="modal fade" id="succ-reg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Successfull registration</h5>
                                </div>
                                <div class="modal-body">
                                    ${result}
                                </div>
                                <div class="modal-footer">
                                    <a href="index.php" class="btn btn-primary">OK let's GO</a>
                                </div>
                                </div>
                            </div>
                            </div>`);
                      $('#succ-reg').modal('show');
                    }
                });
            }
        });
    }
    else if(url == "/single.php"){
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
            ajaxCallback("models/delete-new", send, result=>{
                console.log(result);
                if(result != ""){
                    $('#single-modal').append(`<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Successfull registration</h5>
                                </div>
                                <div class="modal-body">
                                    ${result}
                                </div>
                                <div class="modal-footer">
                                    <a href="index.php" class="btn btn-primary">OK</a>
                                </div>
                                </div>
                            </div>
                            </div>`);
                  $('#delete-modal').modal('show');
                }
            });
        });
    }
    else if(url == "/contact.php"){
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
                ajaxCallback("models/messages", send, result=>{
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
    else if(url == "/all-news.php"){
        let allNews = "all-news.php";
        $('#filterBtn').click(function(){
            let cat = $("#filterNews option:selected").val();
            let sorting =  $("#orderNews option:selected").val();
            if(cat != 0){
                allNews += `?filter=1&cat=${cat}`;
                if(sorting != 0){
                    allNews += `&sort=${sorting}`;
                }
            }
            else if(sorting != 0){
                allNews += `?filter=1&sort=${sorting}`;
            }
            location.href = allNews;
        });
    }
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
            ajaxCallback("models/change-password", send, result=>{
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
$('#klik').click(function(){
    $('#probaDiv').append(`<div class="modal fade" id="moodd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Successfull registration</h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK let's GO</button>
      </div>
    </div>
  </div>
</div>`);
$('#moodd').modal('show');
})
$('#surveyBtn').click(function(){
    let cat = $('#categorySurvey option:selected').val();
    let gender = $('.gender:checked').val();
    formCheck("true", cat == 0 ? "false" : "true", "categorySurvey", "Please select category");
    formCheck("true", gender == undefined ? "false" : "true", "second", "Please select gender");
    if(errors.length == 0){
        let send = {
            cat: cat,
            gender: gender,
            btn: true
        }
        ajaxCallback("models/post-survey", send, result=>{
            serverCheck(result.category ,"category");
            serverCheck(result.gender ,"second");
            if(typeof(result) == "string"){
                $('#surveyBtn').after(`<p class='text-success mt-3'>${result}</p>`);
                setTimeout(function(){
                    window.location.replace("index.php");
                }, 1000);
            }
        });
    }
});
$('.nc-delete-message').click(function(){
    if(errors.length == 0){
        let send = {
            id: $(this).data('id'),
            btn: true
        }
        ajaxCallback("models/delete-message", send, result=>{
            if(result == true){
                location.reload();
            }
        });
    }
});
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
                ajaxCallback("models/post-comment", send, result=>{
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
        if(errors.indexOf(id) > -1) errors.splice(errors.indexOf(id), 1);
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
        if(id == "second") return;
        $(`#${id}`).addClass("border border-danger");
    }
}
