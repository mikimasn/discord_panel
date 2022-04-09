function profile_move()
{
    var profile_photo = document.getElementById("profile_move");
    var v =4;
    console.log("tu też")
    for(i=0;i<100;null)
    {
        i=i+v;
        if(i>100)
        {
            i -=(i-100);
        }
        profile_photo.style+="right:"+i+";";
        v=v-0.1
        console.log("jestem tutaj");
    }
}