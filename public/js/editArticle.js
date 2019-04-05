if(document.querySelector('.btn-edit-article'))
{
    let editButton = document.querySelector('.btn-edit-article');

    editButton.addEventListener('click', (e) =>
    {
        e.preventDefault();

        let image = document.querySelector('.image'),
            title = document.querySelector('.title-article'),
            text = document.querySelector('.text-article'),
            formEdit = document.querySelector('.form-edit-article'),
            cancelButton = document.querySelector('.cancel-article');
        
        // Depending to the data-set in the html page (edit article)
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
            let data = new FormData(formEdit); // instantiate formData object with the formEdit in parameters
            data.append('token_session', e.target.dataset['tokencsrf']);
            data.append('text_article', editor.children[0].innerHTML);

            // Make an Ajax request on the edit article page, we spend data of the form, we return a promise (a tool for managing asynchronous operations)
            fetch('http://localhost/article/edition/'+e.target.dataset['id']+'/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let statut = JSON.parse(promise).statut;
                let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;

                if(statut == 'success')
                {
                    showMessage('success', ['L\'article a bien été édité !']);

                    let article = JSON.parse(promise).content; // in the variable 'article' we stock data from the edit article
                    image.src = 'http://localhost/' + article['image'];
                    title.innerText = article['title_article'];
                    text.innerHTML = article['text_article'];
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