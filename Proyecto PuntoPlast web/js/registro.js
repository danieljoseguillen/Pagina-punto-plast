$(document).ready(function() {
    $("tr.desc").hide();
    $("input[name$='tipousu']").click(function() {
        var test = $(this).val();
        $("tr.desc").hide();
        $("#" + test).show();
    });
});