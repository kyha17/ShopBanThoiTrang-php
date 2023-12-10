<?php
if (!defined('_INCODE')) die('Access Deined...');

?>


<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="<?php assets('assets/vendor/libs/jquery/jquery.js'); ?>"></script>
<script src="<?php assets('assets/vendor/libs/popper/popper.js"'); ?>"></script>
<script src="<?php assets('assets/vendor/js/bootstrap.js'); ?>"></script>
<script src="<?php assets('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>

<script src="<?php assets('assets/vendor/js/menu.js'); ?>"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php assets('assets/vendor/libs/apex-charts/apexcharts.js'); ?>"></script>

<!-- Main JS -->
<script src="<?php assets('assets/js/main.js'); ?>"></script>
<script src="<?php assets('assets/js/check.js'); ?>"></script>
<script src="<?php assets('assets/js/ajax.js?ver='.rand().''); ?>"></script>
<script src="<?php assets('assets/js/cropper.min.js'); ?>"></script>
<script src="<?php assets('assets/js/custom.js'); ?>"></script>
<script type="text/javascript">

</script>
<?php
$body = getBody();
$module = null;
if (!empty($body['module'])){
    $module = $body['module'];
}

?>
<script type="text/javascript">
    let rootUrl = '<?php echo _WEB_HOST_ROOT; ?>';
    let prefixUrl = '<?php echo getPrefixLinkService($module); ?>';
</script>

<script src="<?php echo assets('assets/js/custom.js?ver=').rand()?>"></script>

<script>
    let permissionObj = document.querySelector('.permission-lists');
   
if (permissionObj!==null){
    const allowRoles = [
       
        'add',
        'edit',
        'delete',
      
    ];
    let rowPermissionObj = permissionObj.querySelectorAll('tr');
    if (rowPermissionObj!==null){
        rowPermissionObj.forEach(function (item) {
            let checkboxObj = item.querySelectorAll('input[type="checkbox"]');
        
            if (checkboxObj!==null){
                checkboxObj.forEach(function (checkbox) {
                    checkbox.addEventListener('click', function () {
                       
                        let checkboxValue = this.value;
                        if (checkboxValue.trim()!=='' && allowRoles.includes(checkboxValue)){
                            let viewRole = item.querySelectorAll('input[value="view"]');
                            if (viewRole!==null){
                                viewRole[0].checked = true;
                            }
                        }
                    });
                })
            }
        });
    }
}

</script>

<!-- Page JS -->
<script src="<?php assets('assets/js/dashboards-analytics.js'); ?><"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<script>

</script>
