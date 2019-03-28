if(document.querySelectorAll('.btn-edit-response'))
{
    let editButton = document.querySelectorAll('.btn-edit-response');

    editButton.forEach((button) =>
    {
        button.addEventListener('click', (e) =>
        {
            e.preventDefault();

            let paragraph = document.querySelector('.content-response'+e.target.dataset['id']);
            let cancelBtn = document.querySelector('.cancel-response'+e.target.dataset['id']);
            let formEdit = document.querySelector('.form-edit-response'+e.target.dataset['id']);
            let editTextarea = document.querySelector('.content-response-edit'+e.target.dataset['id']);

            if(e.target.dataset['toggle'] == 'false')
            {
                editTextarea.innerText = paragraph.innerText;
                paragraph.style.display = 'none';
                cancelBtn.style.display = 'initial';
                formEdit.style.display = 'initial';
                e.target.dataset['toggle'] = 'true';

                e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save');
            }
            else if(e.target.dataset['toggle'] == 'true')
            {
                let data = new FormData(formEdit);
                fetch('http://localhost/commentaire/edition/'+e.target.dataset['id']+'/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
                {
                    let statut = JSON.parse(promise).statut;
                    let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;
                    
                    if(statut == 'success')
                    {
                        paragraph.innerText = JSON.parse(promise).content.text_comment;
                        showMessage('success', ['La réponse a bien été éditée !']);
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

                if(document.body.clientWidth < 415)
                {
                    e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                }
                else
                {
                    e.target.innerText = trans(e.target.dataset['locale'], 'Editer la réponse', 'Edit response');
                }
            }

            cancelBtn.addEventListener('click', (f) =>
            {
                f.preventDefault();
                cancelBtn.style.display = 'none';
                e.target.dataset['toggle'] = 'false';

                if(document.body.clientWidth < 415)
                {
                    e.target.innerText = trans(e.target.dataset['locale'], 'Editer', 'Edit');
                }
                else
                {
                    e.target.innerText = trans(e.target.dataset['locale'], 'Editer la réponse', 'Edit response');
                }

                paragraph.style.display = 'block';
                formEdit.style.display = 'none';
                editTextarea.value = paragraph.innerText;
            });
        });
    });
}