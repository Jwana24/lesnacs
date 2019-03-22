if(document.querySelector('.btn-edit-article'))
{
    let editButton = document.querySelector('.btn-edit-article');

    editButton.addEventListener('click', (e) =>
    {
        console.log(e.target);
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
            e.target.innerText = trans(e.target.dataset['locale'], 'Enregistrer', 'Save'); // a custom function to translate the word on the button
        }
        else if(e.target.dataset['toggle'] == 'true')
        {
            let data = new FormData(formEdit); // Instantiate formData object with the formEdit in parameters
            
            // Make an Ajax request on the edit article page, we spend data of the form, we return a promise (a tool for managing asynchronous operations)
            fetch('http://localhost/article/edit/'+e.target.dataset['id']+'/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let statut = JSON.parse(promise).statut;
                let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;

                if(statut == 'success')
                {
                    showMessage('success', ['L\'article a bien été édité !']);

                    let article = JSON.parse(promise).content; // in the variable 'article' we stock data from the edit article
                    image.src = 'http://localhost/' + article['image'];
                    title.innerText = article['title_article'];
                    text.innerText = article['text_article'];
                }
                else if(statut == 'error' && errors == null)
                {
                    showMessage('error', ['Une erreur c\'est produite :(']);
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
            e.target.innerText = trans(e.target.dataset['locale'], 'Editer l\'article', 'Edit article');
        }

        cancelButton.addEventListener('click', (f) =>
        {
            f.preventDefault();

            title.style.display = '';
            text.style.display = '';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.innerText = trans(e.target.dataset['locale'], 'Editer l\'article', 'Edit article');
        });
    })
}