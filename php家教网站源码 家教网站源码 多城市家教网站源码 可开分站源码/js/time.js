
function setjyBG(id,id2) 
{ 
 document.getElementById("mxjy").className=''; 
 document.getElementById("zyjs1").className=''; 
 document.getElementById("dxs").className=''; 
 document.getElementById("yszc").className=''; 
 document.getElementById("jyk1").style.display='none'; 
 document.getElementById("jyk2").style.display='none'; 
 document.getElementById("jyk3").style.display='none'; 
 document.getElementById("jyk4").style.display='none'; 
 document.getElementById(id2).style.display=''; 
 document.getElementById(id).className='xuanz'; 
} 
function setjy(id,id2) 
{ 
 document.getElementById("jybd").className=''; 
 document.getElementById("xybd").className=''; 
 document.getElementById("jy1").style.display='none'; 
 document.getElementById("xy1").style.display='none'; 
 document.getElementById(id2).style.display=''; 
 document.getElementById(id).className='gbbj'; 
} 
function setDivBG(id) 
{ 
 document.getElementById("syjy").className=''; 
 document.getElementById("syxy").className=''; 
 document.getElementById("zyjsuo").className=''; 
 document.getElementById("zyjs").className=''; 
 document.getElementById(id).className='bg'; 
} 

function tick() {
var hours, minutes, seconds, xfile;
var intHours, intMinutes, intSeconds;
var today;
today = new Date();
nian=today.getYear()
yue=today.getMonth()+1
day=today.getDate();
intHours = today.getHours();
intMinutes = today.getMinutes();
intSeconds = today.getSeconds();
if (intHours == 0) {
hours = "12:";
xfile = "午夜";
} else if (intHours < 12) { 
hours = intHours+":";
xfile = "上午";
} else if (intHours == 12) {
hours = "12:";
xfile = "正午";
} else {
//intHours = intHours - 12
hours = intHours + ":";
xfile = "下午";
}
if (intMinutes < 10) {
minutes = "0"+intMinutes+":";
} else {
minutes = intMinutes+":";
}
if (intSeconds < 10) {
seconds = "0"+intSeconds+" ";
} else {
seconds = intSeconds+" ";
}
nian=nian+"年"
yue=yue+"月"
day=day+"日&nbsp;&nbsp;"
//+xfile上午下午
timeString =nian+yue+day+hours+minutes+seconds;
Clock.innerHTML = timeString;
window.setTimeout("tick();", 100);
}
window.onload = tick;
