if(document.querySelectorAll('.lang-link'))
{
    let languages = document.querySelectorAll('.lang-link');

    languages.forEach(language =>
    {
        language.addEventListener('click', (e) =>
        {
            e.preventDefault();

            fetch('/langue/'+ e.target.dataset['locale'] + '/', {method: 'GET'}).then(promise => promise.text()).then(promise =>
            {
                window.location = '';
            });
        });
        
    });
}