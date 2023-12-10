function deleteAjax(elm,url='') {
    $(elm).click(function () {
        let id = $(this).data("id");
        var el = this;

        Swal.fire({
            title: 'Bạn có chắc không?',
            text: "Bạn sẽ không thể khôi phục điều này!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tôi, đồng ý!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:'POST',
                    url:url,
                    data:{id:id},
                    success: function(data){
                        console.log(data);
                        var dataResult = JSON.parse(data);
                        if ( dataResult[0].msgType === 'success'){
                            $(el).closest('tr').fadeOut(800,function(){
                                location.reload();
                            });

                            Swal.fire(
                                'Thành công!',
                                dataResult[0].msg,
                                dataResult[0].msgType
                            )
                        }else{
                            Swal.fire(
                                'Thất bại',
                                dataResult[0].msg,
                                dataResult[0].msgType
                            )
                        }

                    },


                })


            }
        })
    });
}

insertImage();
function insertImage(){
    const reader = new FileReader()
    $('#upload').change(function(event){
        var fileInput = $('#upload');
        let id = $(this).attr("data-id");
        let img =  event.target.files[0];

        if (img) {
            var formData = new FormData();
            formData.append('image', img);
            formData.append('id', id);
            formData.append('fileInput', fileInput);
  
            $.ajax({
                url : '?module=info&action=updateImage',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
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
                        title: 'Signed in successfully'
                      })
                      setTimeout(  location.reload(), 5000);
                  
              },
              error: function(error) {
                console.error('Lỗi khi tải lên:', error);
              }
            });
          } else {
            console.log('Vui lòng chọn một tệp để tải lên.');
          }

       
    })
    // var url = fileUpload.files[0].name
       
  
    
} 

deleteAccount();
function deleteAccount(){
    $('.deactivate-account').click(function(){
        var checked = $('#accountActivation');
        let id = $(this).attr("data-id");
       
        if(checked.is(":checked")){
            Swal.fire({
                title: 'Bạn có chắc không?',
                text: "Xóa không thể khôi phục lại!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, Đồng ý!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : '?module=info&action=deleteAccount',
                        method : "POST",
                        data : {id:id},
                        success: function(data){
                            console.log(data);
                            var dataResult = JSON.parse(data);

                            if ( dataResult[0].msgType === 'success'){
                                Swal.fire(
                                    'Thành công!',
                                    dataResult[0].msg,
                                    dataResult[0].msgType
                                )
                            }else{
                                Swal.fire(
                                    'Thất bại',
                                    dataResult[0].msg,
                                    dataResult[0].msgType
                                )
                            }
                        }
                    })
                    
                  Swal.fire(
                    'Đã xóa!',
                    'Tệp của bạn đã bị xóa.',
                    'success'
                  )
                }
              })
        }
        
    })
}
updateContact();
function updateContact(){
    $.each($('.edit'), function (index, value) { 
        $(value).click(function(){
            let id = $(this).attr("data-id");
            let content = $('.content').val();
            console.log(content);
            $.ajax({
                url : '?module=contact&action=edit',
                method : "POST",
                data : {id:id},
                success: function(data){
                 
                    var dataResult = JSON.parse(data);
    
                    if ( dataResult[0].msgType === 'success'){
                        Swal.fire(
                            'Thành công!',
                            dataResult[0].msg,
                            dataResult[0].msgType
                        )
                    }else{
                        Swal.fire(
                            'Thất bại',
                            dataResult[0].msg,
                            dataResult[0].msgType
                        )
                    }
                }
            })
        })
    });
    
}

