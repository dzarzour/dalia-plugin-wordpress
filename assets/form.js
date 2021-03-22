document.addEventListener('DOMContentLoaded',function(e){

    let $testimonialform=document.getElementById("dalia-testimonial-form");


    $testimonialform.addEventListener('submit',(e)=>{

        e.preventDefault();
        
        //reset the form message 
        resetMessages();
        //validate email
        let data={
            name:   $testimonialform.querySelector('[name="name"]').value,
            email:  $testimonialform.querySelector('[name="email"]').value,
            message:$testimonialform.querySelector('[name="message"]').value,
            nonce  :$testimonialform.querySelector('[name="nonce"]').value
        }
        console.log(data);
        if(! data.name){
            $testimonialform.querySelector('[data-error="invalidName"]').classList.add('show');
          
            return;
        }

        if(!validateEmail(data.email)){
            $testimonialform.querySelector('[data-error="invalidEmail"]').classList.add('show');
            return;
        }
        if(!data.message){
            $testimonialform.querySelector('[data-error="invalidMessage"]').classList.add('show');
            return;
        }
       
        //ajax http post request
        let url=$testimonialform.dataset.url;
        console.log(url);
        let params= new URLSearchParams (new FormData($testimonialform));
        console.log(params);
        $testimonialform.querySelector('.js-form-submission').classList.add('show');


        fetch(url,{
            method:"POST",
            body:params,
        })
        .then(res=>res.json())
        .catch(error =>{
            resetMessages();
            $testimonialform.querySelector('.js-form-error').classList.add('show');
        })
        .then(response=>{

            //deal
            resetMessages();
            if(response===1){

                resetMessages();
            }
            if(response===0 || response.status==='error'){
                $testimonialform.querySelector('js-form-error').classList.add('show');
                return;
            }
           
           // $testimonialform.querySelector('[name="name"]').value='';
           // $testimonialform.querySelector('[name="email"]').value='';
           // $testimonialform.querySelector('[name="message"]').value='';
            $testimonialform.querySelector('.js-form-success').classList.add('show');
           // $testimonialform.reset();
        })
    });
});

function  resetMessages(){
    document.querySelectorAll('.field-msg').forEach(f=>f.classList.remove('show'));
}
function validateEmail(email){
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());

}