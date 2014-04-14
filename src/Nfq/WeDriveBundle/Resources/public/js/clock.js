var Clock = {
    startTime: function() {
        var today=new Date();

        var Y = today.getFullYear();
        var M = today.getMonth();
        var d=today.getDay();

        var h=today.getHours();
        var m=today.getMinutes();
        var s=today.getSeconds();
    // add a zero in front of numbers<10
        M=this.checkTime(M);
        d=this.checkTime(d);

        m=this.checkTime(m);
        s=this.checkTime(s);
        document.getElementById('txt').innerHTML=Y+"-"+M+"-"+d+" "+h+":"+m+":"+s;
        t=setTimeout(function(){Clock.startTime()},500);
    },

    checkTime: function(i) {
        if (i < 10) {
            i="0" + i;
        }

        return i;
    }
}