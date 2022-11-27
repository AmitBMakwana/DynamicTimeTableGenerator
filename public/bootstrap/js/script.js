/* Start goto top */
var mybutton = document.getElementById("myBtn"); window.onscroll = function () { scrollFunction(); };
function scrollFunction() { if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) { mybutton != null ? mybutton.style.display = "block" : ""; } else { mybutton != null ? mybutton.style.display = "none" : ""; } }
$('#myBtn').click(function () { $('body,html').animate({ scrollTop: 0 }, 500); });
/* End goto top */
/* Start dropdown submenu */
$('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
    if (!$(this).next().hasClass('show')) { $(this).parents('.dropdown-menu').first().find('.show').removeClass('show'); }
    var $subMenu = $(this).next('.dropdown-menu'); $subMenu.toggleClass('show');
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) { $('.dropdown-submenu .show').removeClass('show'); }); return false;
});
/* End dropdown submenu */
/* Start Auto signout code */
var signoutAfterSecond = 15 * 60;
var idelTime = 0;
var showWarningAfterSecond = 14 * 60;
var isShowDialog = false;
var warningTimeSecond = signoutAfterSecond - showWarningAfterSecond;
//setInterval("incresesTime()", 1000);
function incresesTime() {
    idelTime += 1;
    //console.log(idelTime);
    if (idelTime > signoutAfterSecond) {
        window.location = $("#signoutUrl").val();
        idelTime = 0;
    }
    if (idelTime > showWarningAfterSecond) {
        if (isShowDialog != true) {
            isShowDialog = true;
            $("#signoutWarningModal").modal('show');
        }
        var pendingPercentage = (idelTime - showWarningAfterSecond) * 100 / warningTimeSecond;
        $("#signoutPrgroessBar").css("width",pendingPercentage+"%");
        $("#signoutPrgroessBar").text((signoutAfterSecond - idelTime)+" Second(s) Remain");
    }
}
function resetTimer(isFromButtonClick = false) {
    if (isShowDialog != true || isFromButtonClick) {
        idelTime = 0; isShowDialog = false;
    }
}
$(document).on('mousemove scroll keyup keypress mousedown mouseup mouseover', function () { resetTimer(); });
/* End Auto signout code */
/** Start for active link */
var activeurl = window.location.href.split("?")[0];
var newactiveurl = activeurl.replace('/create', '');
if (newactiveurl.endsWith("/edit")) {
    newactiveurl = newactiveurl.replace('/edit', '');
}
newactiveurl = newactiveurl.replace(/\/.\d+(?!.*[0-9])/, '');

$('#nav a[href="' + newactiveurl + '"]').addClass('active');
//For make active dropdown item
$('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().addClass("active");
$('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().children("a.nav-link").addClass("stdtextcolor")
//For make active submenu dropdown
if ($('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().hasClass("dropdown-submenu")) {
    $('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().children("a.dropdown-item").addClass("active");
}
//For make main menu dropdown 
if ($('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().parent().parent().hasClass("dropdown")) {
    $('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().parent().parent().addClass("active").addClass("stdtextcolor");
    $('#nav a[href="' + newactiveurl + '"]').parent().parent().parent().parent().parent().children("a.nav-link").addClass("stdtextcolor");
}
/** End for active link */