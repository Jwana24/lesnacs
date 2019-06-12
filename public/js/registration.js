// INSCRIPTION
let formContainerInsc = document.querySelector('form[name=member]');
let closeModal = document.querySelector('.cross-close');
let modalInsc = document.querySelector('.modal_inscription');

let btnInsc = document.querySelector('.btn-inscription');

// CONNECTION
let formContainerCo = document.querySelector('form[name=member-co]');
let closeModalCo = document.querySelector('.cross-close-co');
let modalCo = document.querySelector('.modal_connection');

let btnCo = document.querySelector('.btn-connection');



// INSCRIPTION

formContainerInsc.addEventListener('submit',(e) =>
{
    e.preventDefault();

    let data = new FormData(e.target);

    fetch('http://lesnacs.fr/inscription/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
    {
        modalInsc.style.display = 'none';

        // Browse all the inputs and clear their values
        for(let i = 0; i <= 7; i++)
        {
            formContainerInsc[i].value = '';
        }

        let statut = JSON.parse(promise).statut;
        let errors = (JSON.parse(promise).error != undefined) ? JSON.parse(promise).error : null;

        if(statut == 'success')
        {
            showMessage('success', ['Vous êtes bien inscrits !']);
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
});

closeModal.addEventListener('click', () =>
{
    modalInsc.style.display = 'none';
});

// Show or hide the modal depending on the clicked buttons
btnInsc.addEventListener('click', (e) =>
{
    e.preventDefault();
    modalCo.style.display = 'none';

    if(modalInsc.style.display == 'none' || modalInsc.style.display == '')
    {
        modalInsc.style.display = 'flex';
    }

    else if(modalInsc.style.display == 'flex')
    {
        modalInsc.style.display = 'none';
    }
});


// CONNECTION

closeModalCo.addEventListener('click', () =>
{
    modalCo.style.display = 'none';
});

btnCo.addEventListener('click', (e) =>
{
    e.preventDefault();
    modalInsc.style.display = 'none';

    if(modalCo.style.display == 'none' || modalCo.style.display == '')
    {
        modalCo.style.display = 'flex';
    }

    else if(modalCo.style.display == 'flex')
    {
        modalCo.style.display = 'none';
    }
});

formContainerCo.addEventListener('submit',(e) =>
{
    e.preventDefault();

    let data = new FormData(e.target);

    fetch('http://lesnacs.fr/connexion/', {method: 'POST', body: data}).then(promise => promise.text()).then(promise =>
    {

        modalCo.style.display = 'none';

        for(let i = 0; i <= 1; i++)
        {
            formContainerCo[i].value = '';
        }

        window.location = '';
    });
});