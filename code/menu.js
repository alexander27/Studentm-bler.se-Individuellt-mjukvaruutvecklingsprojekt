
var meny = function () {
    var reaktion = 0; 
    var glid, k;    
    return {   
        menu: function () {
            var m = document.getElementById('meny2');
            if(!m) return;
            var ul = m.getElementsByTagName("ul")[0];
            m.style.width = ul.offsetWidth+1+"px";
            var items = m.getElementsByTagName("li");
            var a = m.getElementsByTagName("a");

            glid = document.createElement("li");
            glid.className = "highlight";
            ul.appendChild(glid);

            var url = document.location.href.toLowerCase();
            k = -1;
            var nLength = -1;
            for (var i = 0; i < a.length; i++) {
                if (url.indexOf(a[i].href.toLowerCase()) != -1 && a[i].href.length > nLength) {
                    k = i;
                    nLength = a[i].href.length;
                }
            }
                                                            //fokus på activa lanken
            if (k > -1) {
                glid.style.width = items[k].offsetWidth + "px";
                
                meny.move(items[k]);
            }
            
                                                                 //foljer musen
            for (var i = 0; i < items.length - 1; i++) {
                items[i].onmouseover = function () {
                    if (k == -1) glid.style.visibility = "visible";
                    if (this.offsetLeft!= glid.offsetLeft) {
                        meny.move(this);
                    }
                }
            }

            m.onmouseover = function () 
            {
                if (glid.t2)
                    glid.t2 = clearTimeout(glid.t2);
            };

            m.onmouseout = function () 
            {
                if (k > -1 && items[k].offsetLeft != glid.offsetLeft) {
                    glid.t2 = setTimeout
                (function () 
                    { meny.move(items[k]); }, 500);
                }
                if (k == -1) glid.t2 = setTimeout
                (function () 
                { glid.style.visibility = "hidden"; }, 500);
            };
        },              //intevall hastighet forflyttning
            move: function (target) 
            {
                clearInterval(glid.timer);
                var direction = (glid.offsetLeft < target.offsetLeft) ?1 :-1;
                glid.timer = setInterval
                (function () 
                { meny.mv(target,                  
                direction); 
                    
                }, 15);
            },
        mv: function (target, direction) 
        {
            if (direction == 1)                                 //direktion av linjen meny 
            {
                if (glid.offsetLeft - reaktion < target.offsetLeft)
                    this.changePosition(target, 1);
                else {
                    clearInterval(glid.timer);
                    glid.timer = setInterval(function () {
                        meny.recoil(target, 1);
                    }, 15);
                }
            }
            else {  
                if (glid.offsetLeft + reaktion > target.offsetLeft)
                    this.changePosition(target, -1);
                else {
                    clearInterval(glid.timer);
                    glid.timer = setInterval
                    (function () 
                    {
                        meny.recoil(target, -1);
                    }, -10);
                }
            }
            this.changeWidth(target);
        },
        recoil: function (target, direction) 
        {
            if (direction == -1) 
            {
                if (glid.offsetLeft > target.offsetLeft) 
                {
                    glid.style.left = target.offsetLeft + "px";
                    clearInterval(glid.timer);
                }
                else glid.style.left = glid.offsetLeft + 2 + "px";
            }
            else 
            {
                if (glid.offsetLeft < target.offsetLeft) {
                    glid.style.left = target.offsetLeft + "px";
                    clearInterval(glid.timer);
                }
                else glid.style.left = glid.offsetLeft - 2 + "px";
            }
        },      
        changePosition: function (target, direction)   // kollar exakta varde och avrundar for att annpassa linje
        {
            if (direction == 1) 
            {
                glid.style.left = glid.offsetLeft + Math.ceil(Math.abs(target.offsetLeft - 
                glid.offsetLeft + reaktion) / 10) + 1 + "px";
            }
            else {
                glid.style.left = glid.offsetLeft - Math.ceil(Math.abs(glid.offsetLeft - target.offsetLeft +                 reaktion) / 10) -                 1 + "px";
            }
        },
        changeWidth: function (target) 
        {
            if (glid.offsetWidth != target.offsetWidth) 
            {
                var diff = glid.offsetWidth - target.offsetWidth;
                if (Math.abs(diff) < 4) glid.style.width = target.offsetWidth + "px";
                else glid.style.width = glid.offsetWidth - Math.round(diff / 3) + "px";
            }
        }
    };
} ();

if (window.addEventListener) {
    window.addEventListener("load",meny.menu, false);
}
else if (window.attachEvent) {
    window.attachEvent("onload", meny.menu);
}
else {
    window["onload"] = meny.menu;
}