let avatarSize = $(window).width();

$(window).on("resize", () =>
{
    let avatarSize = $(window).width();
    
    if(avatarSize <= 415)
    {
        $('.avatar').removeClass('rounded-circle');
    }
    else
    {
        $('.avatar').addClass('rounded-circle');
    }
})

if(avatarSize <= 415)
{
    $('.avatar').removeClass('rounded-circle');
}
else
{
    $('.avatar').addClass('rounded-circle');
}
