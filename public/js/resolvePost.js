if(document.querySelector('.resolve'))
{
    let resolve = document.querySelector('.resolve');
    let textPostResolved = document.querySelector('.text-resolve');

    let commentBtn = document.querySelector('.container-comment-post');
    let replyBtn = document.querySelector('.btn-reply');

    resolve.addEventListener('click', resolved);

    function resolved(e)
    {
        if(confirm('Etes-vous sûr de vouloir résoudre le post ?'))
        {
            e.preventDefault();
            let data = new FormData();
    
            data.append('resolve-post', 'true');
            fetch('/forum/' +resolve.dataset['id']+'/', {method: 'POST', body:data}).then(promise => promise.text()).then(promise =>
            {
                let isResolved = JSON.parse(promise);
    
                if(isResolved.content)
                {
                    e.target.classList.remove('icone-resolve', 'resolve', 'fa-lock-open');
                    e.target.classList.add('fa-lock');
                    e.target.setAttribute('title', '');
                    e.target.setAttribute('style', 'cursor:initial');
                    textPostResolved.innerHTML = `<span>[${trans(e.target.dataset['locale'], 'Post résolu', 'Post resolved')}]</span>`;

                    if(document.querySelector('.container-comment-post'))
                    {
                        commentBtn.remove();
                    }
                    
                    if(document.querySelector('.btn-reply'))
                    {
                        replyBtn.remove();
                    }

                    resolve.removeEventListener('click', resolved);
                }
            })
        }
    }
}
