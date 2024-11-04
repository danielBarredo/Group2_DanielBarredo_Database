function heroName(){
    var hero = prompt("Search a developer");
    if(hero == "May" || hero == "may" || hero == "MAY")
    {
        window.location.assign("poll.html#developers");
    }
    else if(hero == "Daniel" || hero == "daniel" || hero=="DANIEL")
    {
        window.location.assign("poll.html#developers");
    }
    else if(hero == "Beean" || hero == "beean" || hero=="BEEAN")
    {
        window.location.assign("poll.html#developers");
    }
    else if(hero == "JOSE" || hero == "jose" || hero=="JOSE")
    {
        window.location.assign("poll.html#developers");
    }
    else if(hero == "RB" || hero == "rb" || hero=="Rb")
    {
        window.location.assign("poll.html#developers");
    }
    else
    {
        window.location.assign("poll.html");
    }
}