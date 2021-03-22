window.addEventListener("load", function(){
    //store tab variable
    var tabs=document.querySelectorAll("ul.nav-tabs >li");
    for(i=0 ;i<tabs.length; i++){
        tabs[i].addEventListener("click",switchTab);

    }

    function switchTab(event){
       event.preventDefault();

       document.querySelector("ul.nav-tabs li.active").classList.remove("active");
       document.querySelector(".tab-pane.active").classList.remove("active");
       

       var clickedTab   =event.currentTarget;
       var anchor       =event.target;
       console.log("current target " + clickedTab);
       console.log("target " + anchor);
       var activePaneID =anchor.getAttribute("href");
      
       clickedTab.classList.add("active");
       document.querySelector(activePaneID).classList.add("active");
       
      
    }
});

jQuery(document).ready(function ($){
    $(document).on('click','.js-image-upload',function(e){
        e.preventDefault();
       
        var $button     =$(this);
        var file_frame  =wp.media.frames.file_frame=wp.media({
            title:'select or upload image',
            library:{
                type:'image',
            },
            button:{
                text:'select Image'
            },
            multiple:false
        });

        file_frame.on('select',function(){
            var attachment=file_frame.state().get('selection').first().toJSON();
            console.log(attachment);
            $button.siblings('.image-upload').val(attachment.url);
        });

        file_frame.open();
    });


});