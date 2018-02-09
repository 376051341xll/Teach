/*
	程序名称 : 日历
	作者 : ManSon Zhong
	日期 : 2004-3-5
*/


var dDate = new Date();
var tMonth=dDate.getMonth();
var tDayOfMonth=dDate.getDate();
var tYear=dDate.getFullYear();

var dCurMonth = dDate.getMonth()+1;
var dCurDayOfMonth = dDate.getDate();
var dCurYear = dDate.getFullYear();
var dCurDay;

var objPrevElement = new Object();
var objReturnElement =new Object();
var showElement ="";
var returnValueElement;

var months=new Array()
months[1] ="一月份";
months[2] ="二月份";
months[3] ="三月份";
months[4] ="四月份";
months[5] ="五月份";
months[6] ="六月份";
months[7] ="七月份";
months[8] ="八月份";
months[9] ="九月份";
months[10] ="十月份";
months[11] ="十一月份"
months[12] ="十二月份";
                       
function fSetSelectedDay(myElement)
{
	if (myElement.id == "calCell")
    {
		if (!isNaN(parseInt(myElement.children["calDateText"].innerText)))
        {
			dCurDayOfMonth=parseInt(myElement.children["calDateText"].innerText);
			returnValueElement.value=''+dCurYear+'-'+(dCurMonth<10?'0'+dCurMonth:dCurMonth)+'-'+(dCurDayOfMonth<10?'0'+dCurDayOfMonth:dCurDayOfMonth);
			datepickerpop.hide();
			returnValueElement.focus();
	     }
	}
}

function fGetDaysInMonth(iMonth, iYear)
{
	var dPrevDate = new Date(iYear, iMonth, 0);
	return dPrevDate.getDate();
}

function fBuildCal(iYear, iMonth, iDayStyle)
{
	var aMonth = new Array();
	aMonth[0] = new Array(7);
	aMonth[1] = new Array(7);
	aMonth[2] = new Array(7);
	aMonth[3] = new Array(7);
	aMonth[4] = new Array(7);
	aMonth[5] = new Array(7);
	aMonth[6] = new Array(7);

	var dCalDate = new Date(iYear, iMonth-1, 1);
	var iDayOfFirst = dCalDate.getDay();
	var iDaysInMonth = fGetDaysInMonth(iMonth, iYear);
	var iVarDate = 1;
	var i, d, w;

	if (iDayStyle == 2)
    {
		aMonth[0][0] = "Sunday";
		aMonth[0][1] = "Monday";
		aMonth[0][2] = "Tuesday";
		aMonth[0][3] = "Wednesday";
		aMonth[0][4] = "Thursday";
		aMonth[0][5] = "Friday";
		aMonth[0][6] = "Saturday";
	} else if (iDayStyle == 1)
		{
			aMonth[0][0] = "Sun";
			aMonth[0][1] = "Mon";
			aMonth[0][2] = "Tue";
			aMonth[0][3] = "Wed";
			aMonth[0][4] = "Thu";
			aMonth[0][5] = "Fri";
			aMonth[0][6] = "Sat";
		} else  if (iDayStyle == 3)
            {
				aMonth[0][0] = "星期日";
                aMonth[0][1] = "星期一";
                aMonth[0][2] = "星期二";
                aMonth[0][3] = "星期三";
                aMonth[0][4] = "星期四";
                aMonth[0][5] = "星期五";
                aMonth[0][6] = "星期六";
             } else {
				aMonth[0][0] = "Su";
				aMonth[0][1] = "Mo";
				aMonth[0][2] = "Tu";
				aMonth[0][3] = "We";
				aMonth[0][4] = "Th";
				aMonth[0][5] = "Fr";
				aMonth[0][6] = "Sa";
			}

	for (d = iDayOfFirst; d < 7; d++)
    {
		aMonth[1][d] = iVarDate;
		iVarDate++;
	}

	for (w = 2; w < 7; w++)
    {
		for (d = 0; d < 7; d++)
        {
			if (iVarDate <= iDaysInMonth)
            {
				aMonth[w][d] = iVarDate;
				iVarDate++;
			}
		}
	}
	return aMonth;
}

function fDrawCal(iYear, iMonth, iDayStyle)
{
	var myMonth;
	myMonth = fBuildCal(iYear, iMonth, iDayStyle);
	dCurYear=iYear;
	dCurMonth=iMonth;
	Content='';
//	alert(ImgPath);
	Content=Content+"<div id=Datepicker style='padding:0px;background:Window;z-index:10000; position:absolute;border:1px solid WindowText;width:220;height=160;visibility:visible;display:inline;' onselectstart='return false'>";
	Content=Content+"<table border='0'  cellspacing='0' cellpadding='0' bgcolor='#FFFFFF' width='100%'>";
	Content=Content+"<tr bgcolor='ActiveCaption'>";
	Content=Content+"<td bgcolor='ActiveCaption' align='left' height='20' valign='MIDDLE'>&nbsp;</td>";
	Content=Content+"<td bgcolor='ActiveCaption' align='right' height='20' colspan='6' id=_datePickerHeader>";
	Content=Content+"<SELECT NAME='monthList' onchange='parent.selectMonth(this.value)' STYLE='background:highlighttext;color:menutext;FONT-FAMILY:Arial;FONT-SIZE:10px;'>";
	for (i=1;i<13;i++)
	{
		if (i==iMonth)
		{
			Content=Content+"<OPTION VALUE="+i+" SELECTED>"+months[i]+"</OPTION>";
		} else {
			Content=Content+"<OPTION VALUE="+i+">"+months[i]+"</OPTION>";
		}
	}
	Content=Content+"</SELECT>";

	Content=Content+"<SELECT NAME='yearList' onchange='parent.selectYear(this.value)' STYLE='background:highlighttext;color:menutext;FONT-FAMILY:Arial;FONT-WEIGHT: bold;FONT-SIZE:10px;'>";
	for (i=tYear-60;i<tYear+10;i++)
	{
		if (i==iYear)
		{
			Content=Content+"<OPTION VALUE="+i+" SELECTED>"+i+"</OPTION>";
		} else {
			Content=Content+"<OPTION VALUE="+i+">"+i+"</OPTION>";
		}
	}
	Content=Content+"</SELECT>";

	Content=Content+" </td>";
	Content=Content+"</tr>";

	Content=Content+"<tr >";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][0] + "</td>";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][1] + "</td>";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][2] + "</td>";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][3] + "</td>";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][4] + "</td>";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][5] + "</td>";
	Content=Content+"<td align='center' style='FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold;border-bottom:	1px solid WindowText;' height='20'>" + myMonth[0][6] + "</td>";
	Content=Content+"</tr>";
	for (w = 1; w < 7; w++)
    {
		Content=Content+"<tr>";
		for (d = 0; d < 7; d++)
        {
			if ((dCurYear==tYear)&&(dCurMonth==(tMonth+1))&&(tDayOfMonth==parseInt(myMonth[w][d]))) backColor="bgColor='scrollbar'"; else backColor="";
			if (dCurDayOfMonth==parseInt(myMonth[w][d])) borderColor="border:1px solid tomato;"; else borderColor="";

			if (!isNaN(parseInt(myMonth[w][d])))
			{
				Content=Content+"<td align='center' "+backColor+" width='30' height='18' id=calCell style='"+borderColor+"CURSOR:Hand' onclick='parent.fSetSelectedDay(this)'>";
			} else {
				Content=Content+"<td align='center' "+backColor+" width='30' height='18' id=calCell  onclick='parent.fSetSelectedDay(this)'>";
			}

			if ((d==0)||(d==6)) fontColor="Red"; else fontColor="windowtext";

            if (!isNaN(parseInt(myMonth[w][d])))
            {
				Content=Content+"<font id=calDateText COLOR='"+fontColor+"' style='CURSOR:Hand;FONT-FAMILY:Arial;FONT-SIZE:10;FONT-WEIGHT:bold' onclick=parent.fSetSelectedDay(this)>" + myMonth[w][d] + "</font>";
            } else {
                Content=Content+"<font id=calDateText COLOR='"+fontColor+"' style='CURSOR:Hand;FONT-FAMILY:Arial;FONT-SIZE:10;FONT-WEIGHT:bold' onclick=parent.fSetSelectedDay(this) >&nbsp;</font>";
            }
			Content=Content+"</td>";
		}
		Content=Content+"</tr>";
	}
	Content=Content+"<tr >";
	Content=Content+"<td align='center' style='color:#ffffff;FONT-FAMILY:Arial;FONT-SIZE:9px;FONT-WEIGHT: bold' height='10'>&nbsp;</td>";
	Content=Content+"<td colspan='6' style='color:#000000;FONT-FAMILY:Arial;FONT-SIZE:11px;FONT-WEIGHT: bold' height='10' align='right'>";
	Content=Content+"<font id=buileToday style='CURSOR:Hand;color:#000000;FONT-FAMILY:Arial;FONT-SIZE:11px;FONT-WEIGHT: bold' onclick='parent.gotoToday()'>Today : "+tYear+"-"+tMonth+"-"+tDayOfMonth+"&nbsp;&nbsp;</font></td>";
	Content=Content+"</tr>";
	Content=Content+"</table>";
	Content=Content+"</DIV>";

	return Content;
}

function CreateDatePicker() {
	content=fDrawCal(dCurYear,dCurMonth,1);
	if (content!='') {
		datepickerpop=window.createPopup();
		datepickerpop.document.body.style.background="ActiveCaption";
		datepickerpop.document.body.innerHTML=content;
	}
}

//显示日历
function showDatePicker(element) {
	returnValueElement=element;
	cHeight=element.offsetHeight;

	if (IsValidDate(element.value)) {
		tempArray = element.value.split("-");
		year=parseInt(tempArray[0]*1);
		month=parseInt(tempArray[1]*1);
		day=parseInt(tempArray[2]*1);
	} else {
		year=tYear;
		month=tMonth;
		day=tDayOfMonth;
	}
	
	dCurDayOfMonth=day;
	content=fDrawCal(year,month,1);
	if (content!='') {
		datepickerpop.document.body.innerHTML=content;
	}

	tTop=getTop(element)-document.body.scrollTop;
	tLeft=getLeft(element)-document.body.scrollLeft;
	datepickerpop.show(tLeft,(tTop+cHeight),220,164,document.body);
}

function showDatePicker1(element,top) {
	returnValueElement=element;
	cHeight=element.offsetHeight;

	if (IsValidDate(element.value)) {
		tempArray = element.value.split("-");
		year=parseInt(tempArray[0]*1);
		month=parseInt(tempArray[1]*1);
		day=parseInt(tempArray[2]*1);
	} else {
		year=tYear;
		month=tMonth;
		day=tDayOfMonth;
	}
	
	dCurDayOfMonth=day;
	content=fDrawCal(year,month,1);
	if (content!='') {
		datepickerpop.document.body.innerHTML=content;
	}

	tTop=getTop(element)-document.body.scrollTop-top;
	tLeft=getLeft(element)-document.body.scrollLeft;
	datepickerpop.show(tLeft,(tTop+cHeight),220,164,document.body);
}

function getTop(e){
	var t=e.offsetTop
	while(e=e.offsetParent){
		t+=e.offsetTop
	}
	return t;
}

function getLeft(e){
	var l=e.offsetLeft
	while(e=e.offsetParent){
		l+=e.offsetLeft
	}
	return l;
}

function fUpdateCal(iMonth)
{
	content=fDrawCal(dCurYear,dCurMonth,1);
	if (content!='') {
		datepickerpop.document.body.innerHTML=content;
	}
}

function selectMonth(mon) {
	dCurMonth=mon;
	fUpdateCal(mon);
}

function selectYear(year) {
	dCurYear=year;
	fUpdateCal(dCurMonth);
}

function gotoToday()
{
	dCurYear=tYear;
	dCurDayOfMonth=tDayOfMonth;
	content=fDrawCal(dCurYear,tMonth+1,1);
	if (content!='') {
		datepickerpop.document.body.innerHTML=content;
	}

}

//建立日历
CreateDatePicker();


function IsValidDate(DateString , Dilimeter)
{
	if (DateString==null) return false;
	if (Dilimeter=='' || Dilimeter==null)
		Dilimeter = '-';
	var tempy='';
	var tempm='';
	var tempd='';
	var tempArray;
	if (DateString.length<8 || DateString.length>10) return false;
	tempArray = DateString.split(Dilimeter);
	if (tempArray.length!=3)
		return false;
	if (tempArray[0].length==4)
	{
		tempy = tempArray[0];
		tempd = tempArray[2];
	}
	else
	{
		tempy = tempArray[2];
		tempd = tempArray[1];
	}
	tempm = tempArray[1];
	if (tempm.charAt(0)=="0")
	{
		tempm=tempm.charAt(1);
	}

	tempd = tempArray[1];
	if (tempd.charAt(0)=="0")
	{
			tempd=tempd.charAt(1);
	}

	if ((tempm>12) ||(tempd>31)) return false;
	var tDateString = tempy + '/'+tempm + '/'+tempd+' 8:0:0';
	var tempDate = new Date(tDateString);

	if (isNaN(tempDate))return false;
	if (((tempDate.getUTCFullYear()).toString()==tempy) && (tempDate.getMonth()==parseInt(tempm)-1) && (tempDate.getDate()==parseInt(tempd)))
	{
			return true;
	}
	else
	{
			return false;
	}
}
