<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<script >
$(document).ready(function (){
$('.header__menu ul').find('li.active').removeAttr('class','active');
$('.header__menu ul').find('li.mn-6').addClass('active');
// var currentBackground=0;
// var myArray=[];
// $_loop();
// setTimeout(changeBackground, 10000); function $_loop(){
// $.ajax({
// type:"POST",
// dataType:'json',
// url:"<?php echo base_url('home/get_imageList');?>",
// success:function (msg){
// $(msg.data).each(function(i){
// myArray=msg.data ;});}});}
// function changeBackground(){
// currentBackground++;
// if (currentBackground==myArray.length ) currentBackground=0;
// $('.breadcrumb-option').fadeOut(1500, function (){
// $(this).css('background-image', 'url(<?php echo base_url('asset/images/ads/')?>' + myArray[currentBackground] + ')').fadeIn(1500);});
// setTimeout(changeBackground, 10000);}
}); 
</script>