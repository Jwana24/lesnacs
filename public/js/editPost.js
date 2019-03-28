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
            e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save');
        }
        else if(e.target.dataset['toggle'] == 'true')
        {
            let data = new FormData(formEdit);
            
            fetch('http://localhost/post/edition/'+e.target.dataset['id']+'/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
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

            if(document.body.clientWidth < 415)
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
            }
            else
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer le post', 'Edit post');
            }
        }

        cancelButton.addEventListener('click', (f) =>
        {
            f.preventDefault();

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            
            if(document.body.clientWidth < 415)
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
            }
            else
            {
                e.target.innerText = trans(e.target.dataset['locale'], 'Editer le post', 'Edit post');
            }
        });
    })
}