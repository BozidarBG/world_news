var replyBtns=document.getElementsByClassName('comment-reply');

for(var x=0; x<replyBtns.length; x++){
    replyBtns[x].addEventListener('click', function(e){
        toggleReplyForm(e);
    });
}

function toggleReplyForm(ev){
    ev.preventDefault();
    var targetClasses=ev.target.parentElement.parentElement.nextElementSibling.classList;
    if(targetClasses.contains('hiddenReplyForm')){
        targetClasses.remove('hiddenReplyForm');
    }else{
        targetClasses.add('hiddenReplyForm');
    }
}

