<?php 
    $getAllSlide = getRaw('SELECT slides.id as slides_id, slides.name as slides_name,image,title FROM slides');
   
    echo json_encode($getAllSlide);
?>