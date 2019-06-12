if(document.querySelectorAll('.btn-edit-comment'))
{
    let editButton = document.querySelectorAll('.btn-edit-comment');

    editButton.forEach((button) =>
    {
        button.addEventListener('click', (e) =>
        {
            e.preventDefault();

            let paragraph = document.querySelector('.content-comment'+e.target.dataset['id']);
            let cancelBtn = document.querySelector('.cancel-comment'+e.target.dataset['id']);
            let formEdit = document.querySelector('.form-edit-comment'+e.target.dataset['id']);
            let editTextarea = document.querySelector('.content-comment-edit'+e.target.dataset['id']);

            if(e.target.dataset['toggle'] == 'false')
            {
                editTextarea.innerText = paragraph.innerText;
                paragraph.style.display = 'none';
                cancelBtn.style.display = 'initial';
                formEdit.style.display = 'initial';
                e.target.dataset['toggle'] = 'true';
                e.target.classList.remove('fa-pencil-alt');
                e.target.classList.add('fa-check');
            }
            else if(e.target.dataset['toggle'] == 'true')
            {
                let data = new FormData(formEdit);
                fetch('http://lesnacs.fr/commentaire/edition/'+e.target.dataset['id']+'/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
                {
                    
                    let statut = JSON.parse(promise).statut;
                    let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;
                    
                    if(statut == 'success')
                    {
                        paragraph.innerText = JSON.parse(promise).content.text_comment;
                        showMessage('success', ['Le commentaire a bien été édité !']);
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

                formEdit.style.display = 'none';
                paragraph.style.display = 'block';
                cancelBtn.style.display = 'none';
                e.target.dataset['toggle'] = 'false';
                
                // if(document.body.clientWidth < 415)
                // {
                //     e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                // }
                // else
                // {
                //     e.target.innerText = trans(e.target.dataset['locale'], 'Editer le commentaire', 'Edit comment');
                // }
                e.target.classList.remove('fa-check');
                e.target.classList.add('fa-pencil-alt');
            }

            cancelBtn.addEventListener('click', (f) =>
            {
                f.preventDefault();
                cancelBtn.style.display = 'none';
                e.target.dataset['toggle'] = 'false';
                
                // if(document.body.clientWidth < 415)
                // {
                //     e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                // }
                // else
                // {
                //     e.target.innerText = trans(e.target.dataset['locale'], 'Editer le commentaire', 'Edit comment');
                // }

                paragraph.style.display = 'block';
                formEdit.style.display = 'none';
                editTextarea.value = paragraph.innerText;
                e.target.classList.remove('fa-check');
                e.target.classList.add('fa-pencil-alt');
            });
        });
    });
}