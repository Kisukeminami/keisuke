
   $('#btn').click(function () { 
       $('#main-manu').fadeIn(500);
       $('body').css('background-color','rgba(255,255,255,0.8)');
       $('h2,h1,section').css('display','none');
       

       
   });

   $('#main-manu>nav').hover(function () {
        $(this).animate({ 'font-size':'1.5em'},100);
        $(this).css({'text-shadow':'1px 1px 3px #d00'})
           
       }, function () {
        $(this).animate({'font-size':'1em' },100);   
        $(this).css({'text-shadow':'none'})

       });
       
   

/*$('#close-btn').click(function () { 
    $('#main-manu').fadeOut(30);
    $('body').css( 'background-color','rgba(67, 124, 56, 0.4)');
    $('h2,h1').css('display','block');
   
});*/

$('#close-btn').click(function () { 
    $.when($('#main-manu').fadeOut(300)
    ).done(function(){
    $('body').css( 'background-color','rgba(67, 124, 56, 0.4)'),
    $('h2,h1,section').css('display','block');
    });
       
});



$('.sablist').click(function() {
	$('.sablist').toggleClass('sablist_a');
    $('#newsmenu').slideToggle()

})
