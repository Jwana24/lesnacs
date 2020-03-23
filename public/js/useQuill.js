if(document.querySelector('#editor'))
{
// Quill editor js
    var quill = new Quill('#editor',
    {
    theme: 'snow'
    });

    // Script qui s'éxécute dès qu'il y a un changement au niveau du text
    quill.on('text-change', function(delta, oldDelta, source)
    {
        document.querySelector('#textQuillInput').value = quill.root.innerHTML;
    });
}

if(document.querySelector('#editor1'))
{
    var quill1 = new Quill('#editor1',
    {
    modules: {toolbar: false},
    theme: 'snow'
    });
    quill1.enable(false);
}