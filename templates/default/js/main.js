$(document).ready(function() {
    $.widget.bridge('uibutton', $.ui.button);
    $('#example').DataTable({
        responsive: true
    });
})
function share_facebook()
{
    u=location.href;t=document.title;
    window.open("http://www.facebook.com/share.php?u="+encodeURIComponent(u)+"&t="+encodeURIComponent(t))
}
function share_google()
{
    u=location.href;
    t=document.title;
    window.open("http://www.google.com/bookmarks/mark?op=edit&bkmk="+encodeURIComponent(u)+"&title="+t+"&annotation="+t)
}
function share_twitter()
{
    u=location.href;
    t=document.title;
    window.open("http://twitter.com/home?status="+encodeURIComponent(u))
}
function share_digg()
{
    u=location.href;
    t=document.title;
    window.open("http://digg.com/submit?phase=2&url="+encodeURIComponent(u)+"&title="+t);
    window.open("http://del.icio.us/post?v=2&url="+encodeURIComponent(u)+"&notes=&tags=&title="+t);
}
function share_delicious()
{
    u=location.href;
    t=document.title;
    window.open("http://del.icio.us/post?v=2&url="+encodeURIComponent(u)+"&notes=&tags=&title="+t);
}
function OpenPrint()
{
    u=location.href;
    window.open(u+"&print=1");
    return false
}