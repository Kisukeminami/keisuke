 //中央のクリックボタンをクリックで発火、
  //バックグランドを見ずらく、#main-manuを表示
     $('#btn').click(function () 
     { 
       $('#main-manu').fadeIn(500);
       $('body').css('background-color','rgba(255,255,255,0.8)');
       $('h2,h1,section').css('display','none');
       

       
   });
//main-manuのnavをホバーで文字が大きく、色も変わる
   $('#main-manu>nav').hover(function () 
   {
        $(this).animate({ 'font-size':'1.5em'},100);
        $(this).css({'text-shadow':'1px 1px 3px #d00'})
           
       }, 
       function () 
       {
        $(this).animate({'font-size':'1em' },100);   
        $(this).css({'text-shadow':'none'})

       });
       
   

/*$('#close-btn').click(function () { 
    $('#main-manu').fadeOut(30);
    $('body').css( 'background-color','rgba(67, 124, 56, 0.4)');
    $('h2,h1').css('display','block');
   
});*/
//#close-btnを押せばメニューが閉じる、背景も戻る
$('#close-btn').click(function ()
 { 
    $.when($('#main-manu').fadeOut(300)
    ).done(function()
    {
    $('body').css( 'background-color','rgba(67, 124, 56, 0.4)'),
    $('h2,h1,section').css('display','block');
    });
       
});


//クリックするとNEWSが表示
$('.sablist').click(function() 
{
	$('.sablist').toggleClass('sablist_a');
    $('#newsmenu').slideToggle()

})

/*$('.sablist,#newsmenu').on({
    mouseenter:function(){
       $('.sablist').toggleClass('sablist_a');
       $('#newsmenu').fadeIn(200)
   },
    mouseout:function(){
       $('.sablist').toggleClass('sablist_a');
       $('#newsmenu').fadeOut(200)
    }
}) 
$('.sablist,#newsmenu,newsmenu').on({
    mouseenter:function(){
       $('.sablist').toggleClass('sablist_a');
       $('#newsmenu').fadeIn(200)
   },function(){
       $('.sablist').toggleClass('sablist_a');
       $('#newsmenu').fadeOut(200)
    }
}) */
    
