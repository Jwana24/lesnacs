if(document.querySelector('.btn-edit-member'))
{
    let editButton = document.querySelector('.btn-edit-member');

    editButton.addEventListener('click', (e) =>
    {
        e.preventDefault();

        let infoProfile = document.querySelector('.info-profile'),
            username = document.querySelector('.username-profile'),
            firstName = document.querySelector('.member-firstName'),
            lastName = document.querySelector('.member-lastName'),
            mail = document.querySelector('.member-mail'),
            description = document.querySelector('.member-description'),
            avatar = document.querySelector('.avatar'),
            formEdit = document.querySelector('.form-edit-member'),
            cancelButton = document.querySelector('.cancel-member');

        if(e.target.dataset['toggle'] == 'false')
        {
            infoProfile.style.display = 'none';
            formEdit.style.display = 'initial';
            cancelButton.style.display = 'inline-block';
            e.target.dataset['toggle'] = 'true';
            e.target.classList.remove('fa-pencil-alt');
            e.target.classList.add('fa-check');
        }

        else if(e.target.dataset['toggle'] == 'true')
        {
            let data = new FormData(formEdit);
            data.append('token_session', e.target.dataset['tokencsrf']);

            fetch('/profil/edition/'+e.target.dataset['id']+ '/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
            {
                let member = JSON.parse(promise).content;
                let statut = JSON.parse(promise).statut;
                let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;

                if(statut == 'success')
                {
                    showMessage('success', ['Le profil a bien été édité !']);
                    console.log(e.target.dataset['locale']);
                    username.innerText = member['username'];
                    lastName.innerText = trans(e.target.dataset['locale'], 'Nom : ','Last name : ') + member['last_name'];
                    firstName.innerText = trans(e.target.dataset['locale'], 'Prénom : ','First name : ') + member['first_name'];
                    mail.innerText = trans(e.target.dataset['locale'], 'Email : ','Mail : ') + member['mail'];
                    description.innerText = 'Description : ' + member['description'];
                    avatar.src = 'http://lesnacs.fr/' + member['avatar'] + '?a=' + Math.random();
                }
                else if(statut == 'error')
                {
                    showMessage('error', errors);
                }

            });

            infoProfile.style.display = 'initial';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.classList.remove('fa-check');
            e.target.classList.add('fa-pencil-alt');
        }

        cancelButton.addEventListener('click', (f) =>
        {
            f.preventDefault();

            infoProfile.style.display = 'initial';
            formEdit.style.display = 'none';
            cancelButton.style.display = 'none';
            e.target.dataset['toggle'] = 'false';
            e.target.classList.remove('fa-check');
            e.target.classList.add('fa-pencil-alt');
        });
    });
}