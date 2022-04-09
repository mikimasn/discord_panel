$(document).ready(function(){

    function main()
    {
        var gid = document.getElementById('gid').value;
    $.post('checkstatus.php', {id:gid}, function(data){
        
    });
    
}
    var chackin = setInterval(main,5000,null)
});