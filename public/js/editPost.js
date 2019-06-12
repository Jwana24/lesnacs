if(document.querySelector('.btn-edit-post'))
{
    let editButton = document.querySelector('.btn-edit-post');

    editButton.addEventListener('click', (e) =>
    {
        e.preventDefault();

        let title = document.querySelector('.title-post'),
            text = document.querySelector('.text-post'),
            formEdit = document.querySelector('.form-edit-post'),
            cancelButton = document.querySelector('.cancel-post');

        if(e.target.dataset['toggle'] == 'false')
        {
            title.style.display = 'none';
            text.style.display = 'none';
            formEdit.style.display = 'initial';
            cancelButton.style.display = 'inline-block';
            e.target.dataset['toggle'] = 'true';
            e.target.classList.remove('fa-pencil-alt');
            e.target.classList.add('fa-check');
        }
        else if(e.target.dataset['toggle'] == 'true')
        {
            let editor = document.querySelector('#editor');
            let data = new FormData(formEdit);
            data.append('token_session', e.target.dataset['tokencsrf']);
            data.append('text_post', editor.children[0].innerHTML);
            
            fetch('http://lesnacs.fr/post/edition/'+e.target.dataset['id']+'/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let statut = JSON.parse(promise).statut;
                let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;
                
                if(statut == 'success')
                {
                    showMessage('success', ['Le post a bien été édité !']);
                    
                    let post = JSON.parse(promise).content;
                    title.innerText = post['title_post'];
                    text.innerHTML = post['text_post'];
                }
                else if(statut == 'error' && errors == null)
                {
                    showMessage('error', ['Une erreur s\'est produite :(']);
                }
                else if(statut == 'error')
                {
                    showMessage('error', errors);
                }
            });

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.classList.remove('fa-check');
            e.target.classList.add('fa-pencil-alt');
        }

        cancelButton.addEventListener('click', (f) =>
        {
            f.preventDefault();

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.classList.remove('fa-check');
            e.target.classList.add('fa-pencil-alt');
        });
    })
}