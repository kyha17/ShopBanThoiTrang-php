setTimeout(function () {
    $('#alert').css("display","none");
},2000);

$.each($('.title'), function (index, value) {
    $(value).click(function () {
        if(index==0){
            $('.id2').css('display','none')
            $('#title2').val('');
        }

        if(index==1){
            $('.id1').css('display','none')
            $('#title1').val('');
        }
    })

   
});

$(document).click(function(event) {
    // Kiểm tra nếu phần tử được click không phải là myElement hoặc là con của myElement
    if (!$(event.target).closest('.card-body').length) {
      // Hiển thị thông báo khi click ra khỏi myElement
      
      $('.id2').css('display','block')
   
      $('.id1').css('display','block')
    }
});



function toSlug(title) {
    let slug = title.toLowerCase(); //Chuyển thành chữ thường

    slug = slug.trim(); //Xoá khoảng trắng 2 đầu

    //lọc dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'u');
    slug = slug.replace(/đ/gi, 'd');

    //chuyển dấu cách (khoảng trắng) thành gạch ngang
    slug = slug.replace(/ /gi, '-');

    //Xoá tất cả các ký tự đặc biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');

    return slug;
}



//Lấy id từ url


    let fullUrl = window.location.href;


    let searchParams = new URLSearchParams(fullUrl);
    let id = searchParams.get('id');

    let sourceTitle = document.querySelector('.slug');
    let slugRender = document.querySelector('.render-slug');

    let renderLink = document.querySelector('.render-link');


if (sourceTitle!==null && slugRender!==null){
    sourceTitle.addEventListener('keyup', (e)=>{

        if (!sessionStorage.getItem('save_slug')){
            let title = e.target.value;

            if (title!==null){
                let slug = toSlug(title);

                slugRender.value = slug;
            }
        }

    });

    sourceTitle.addEventListener('change', ()=>{
        sessionStorage.setItem('save_slug', 1);

        if (id!==null){
            let currentLink = rootUrl+'/'+prefixUrl+'/'+slugRender.value.trim()+'-'+id+'.html';
            console.log(currentLink);

            renderLink.querySelector('span a').innerHTML=currentLink;
            renderLink.querySelector('span a').href=currentLink;
        }

    });

    slugRender.addEventListener('change', (e)=>{
        let slugValue = e.target.value;
        if (slugValue.trim()==''){
            sessionStorage.removeItem('save_slug');
            let slug = toSlug(sourceTitle.value);
            e.target.value = slug;
        }

        if (id!==null){
            let currentLink = rootUrl+'/'+prefixUrl+'/'+slugRender.value.trim()+'-'+id+'.html';

            renderLink.querySelector('span a').innerHTML=currentLink;
            renderLink.querySelector('span a').href=currentLink;
        }

    });

    if (slugRender.value.trim()==''){
        sessionStorage.removeItem('save_slug');
    }
}

let classTextarena = document.querySelectorAll('#editor');
if(classTextarena !== null){
    classTextarena.forEach((item,index)=>{
        item.id = 'editor_'+(index +1 );
        CKEDITOR.replace(item.id,{
            filebrowserBrowseUrl: '/templates/admin/assets/js/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl :'/templates/admin/assets/js/ckfinder/ckfinder.html?type=Images',
            filebrowserUploadUrl: '/templates/admin/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl :'/templates/admin/assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        });
        
    })
}


function openCkFinder() {
    let chooseImages = document.querySelectorAll('.choose-images');
    if (chooseImages!==null){
        chooseImages.forEach(function(item){

            item.addEventListener('click', function(){

                let parentElementObject = this.parentElement;
                while (parentElementObject){

                    parentElementObject = parentElementObject.parentElement;

                    if (parentElementObject.classList.contains('ckfinder-group')){
                        break;
                    }
                }

                CKFinder.popup( {
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ) {
                            let fileUrl = evt.data.files.first().getUrl(); //Xử lý chèn link ảnh vào input

                            parentElementObject.querySelector('.image-render').value = fileUrl;
                        } );
                        finder.on( 'file:choose:resizedImage', function( evt ) { let fileUrl = evt.data.resizedUrl;
//Xử lý chèn link ảnh vào input
                            parentElementObject.querySelector('.image-render').value = fileUrl;
                        } ); }
                } );
            });

        });
    }

}

openCkFinder();

//Xử lý thêm sự kiện dưới dạng repeater
const galleryItemHTML = ' <div class="gallery-item mt-4">\n' +
    '                                        <div class="row ckfinder-group">\n' +
    '                                            <div class="col-9 ">\n' +
    '                                                <input class="form-control form-control-sm image-render"\n' +
    '                                                        name="gallery[]"\n' +
    '                                                       type="text"\n' +
    '                                                       value="" >\n' +
    '                                            </div>\n' +
    '                                            <div class="col-2">\n' +
    '                                                <button type="button" class="btn btn-sm btn-info w-100  choose-images">Chọn ảnh</button>\n' +
    '                                            </div>\n' +
    '                                            <div class="col-1">\n' +
    '                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger remove">Xóa</a>\n' +
    '                                            </div>\n' +
    '                                        </div>\n' +
    '                                    </div>';


const addGalleryObject = document.querySelector('.add-gellery');
const galleryImagesObject = document.querySelector('.gallery-image');


if(addGalleryObject !== null && galleryImagesObject !== null){
    addGalleryObject.addEventListener('click',function (e) {
        e.defaultPrevented;

        let galleryItemHtmlNode = new DOMParser().parseFromString(galleryItemHTML, 'text/html').querySelector('.gallery-item');
        galleryImagesObject.appendChild(galleryItemHtmlNode);
        openCkFinder();
    });

    galleryImagesObject.addEventListener('click',function (e) {
        e.defaultPrevented;

        if(e.target.classList.contains('remove') || e.target.parentElement.classList.contains('remove')){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let galleryItem = e.target;
                    while (galleryItem){

                        galleryItem = galleryItem.parentElement;

                        if (galleryItem.classList.contains('gallery-item')){
                            break;
                        }


                    }
                    if(galleryItem !==null){
                        galleryItem.remove();
                    }

                }
            })
        }
    });


}



