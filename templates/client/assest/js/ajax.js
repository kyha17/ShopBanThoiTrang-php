$(document).ready(function () {
  var btnRegister = $("#btnRegister");
  var btnLogin = $("#btnLogin");


  $(btnRegister).on("click", function () {
    var email = $("#signup-email").val();
    var name = $("#signup-username").val();
    var password = $("#signup-password").val();
    var ckechPass = $('#accept-terms');
    if ($(ckechPass).is(":checked")) {
        $.ajax({
            type: "post",
            url: "?module=auth&action=registerAjax",
            data: {
                email : email,
                name : name,
                password : password,
           
            },
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Đăng ký thành công',
                        showConfirmButton: true,
                        timer: 1500
                      })
                      $('.cd-user-modal').removeClass('is-visible');
                }else{
                    var errors = response.errors;
                    $('.error-name').html(errors.name);
                    $('.error-email').html(errors.email);
                    $('.error-password').html(errors.password);
                }
               
            }
        });
    } else {
        Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Vui lòng chấp nhận diều khoản',
            showConfirmButton: true,
            timer: 1500
          })
    }

    
  });

  $(btnLogin).on("click", function () {
    var email = $("#signin-email").val();
    var password = $("#signin-password").val();
    $.ajax({
        type: "post",
        url: "?module=auth&action=loginAjax",
        data: {
            email : email,
            password : password,
       
        },
        dataType: 'json',
        success: function (response) {
          console.log(response);
           if(response.success){
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
              
              Toast.fire({
                icon: 'success',
                title: response.success
              })
              setTimeout(function() {
                location.reload();
            }, 1000);
              $('.cd-user-modal').removeClass('is-visible');
              
           }else{
                Swal.fire({
                    position: 'center',
                    icon: 'warning',
                    title: response.errors,
                    showConfirmButton: false,
                    timer: 1500
                })
           }
        }
    });

    
  });

 

  checkOption();
});

function checkOption(){
  $('#addOrder').on('click', function (e) {
    if($('#size').val() == 'null' || $('#color').val() == 'null'){
      e.preventDefault()
      const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: 'error',
        title: 'Vui lòng chọn màu sắc và kích cỡ'
      })
    }
  });
 
}