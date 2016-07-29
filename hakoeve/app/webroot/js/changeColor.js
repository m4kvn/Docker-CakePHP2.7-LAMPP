window.onload = initialize;
function initialize() {
    document.getElementById( "day_button" ).onmouseout = day_onout;
    document.getElementById( "day_button" ).onmouseover = day_onover;
    document.getElementById( "category_button" ).onmouseout = category_onout;
    document.getElementById( "category_button" ).onmouseover = category_onover;
    document.getElementById( "map_button" ).onmouseout = map_onout;
    document.getElementById( "map_button" ).onmouseover = map_onover;
    document.getElementById( "poster_button" ).onmouseout = poster_onout;
    document.getElementById( "poster_button" ).onmouseover = poster_onover;
    document.getElementById( "all_button" ).onmouseout = all_onout;
    document.getElementById( "all_button" ).onmouseover = all_onover;
    document.getElementById( "recco_area0" ).onmouseout = recco_onout0;
    document.getElementById( "recco_area0" ).onmouseover = recco_onover0;
    document.getElementById( "recco_area1" ).onmouseout = recco_onout1;
    document.getElementById( "recco_area1" ).onmouseover = recco_onover1;
    document.getElementById( "recco_area2" ).onmouseout = recco_onout2;
    document.getElementById( "recco_area2" ).onmouseover = recco_onover2;
	document.getElementById( "recco_area3" ).onmouseout = recco_onout3;
    document.getElementById( "recco_area3" ).onmouseover = recco_onover3;
}


function day_onover() {
    document.getElementById( "day_arrow" ).setAttribute("src", document.getElementById( "day_arrow" ).getAttribute("src").replace("_off.", "_on."));
    document.getElementById( "day_line" ).style.backgroundColor = "#ff5514";
}
function day_onout() {
    document.getElementById( "day_arrow" ).setAttribute("src", document.getElementById( "day_arrow" ).getAttribute("src").replace("_on.", "_off."));
    document.getElementById( "day_line" ).style.backgroundColor = "";
}

function category_onover() {
    document.getElementById( "category_arrow" ).setAttribute("src", document.getElementById( "category_arrow" ).getAttribute("src").replace("_off.", "_on."));
    document.getElementById( "category_line" ).style.backgroundColor = "#ff5514";
}

function category_onout() {
    document.getElementById( "category_arrow" ).setAttribute("src", document.getElementById( "category_arrow" ).getAttribute("src").replace("_on.", "_off."));
    document.getElementById( "category_line" ).style.backgroundColor = "";
}

function map_onover() {
    document.getElementById( "map_arrow" ).setAttribute("src", document.getElementById( "map_arrow" ).getAttribute("src").replace("_off.", "_on."));
    document.getElementById( "map_line" ).style.backgroundColor = "#ff5514";
}

function map_onout() {
    document.getElementById( "map_arrow" ).setAttribute("src", document.getElementById( "map_arrow" ).getAttribute("src").replace("_on.", "_off."));
    document.getElementById( "map_line" ).style.backgroundColor = "";
}

function poster_onover() {
    document.getElementById( "poster_line" ).style.backgroundColor = "#ff5514";
}
function poster_onout() {
    document.getElementById( "poster_line" ).style.backgroundColor = "";
}

function all_onover() {
    document.getElementById( "all_line" ).style.backgroundColor = "#ff5514";
}
function all_onout() {
    document.getElementById( "all_line" ).style.backgroundColor = "";
}


function recco_onover0() {
    document.getElementById( "recc_access_tab0" ).style.backgroundColor = "#ff5514";
}
function recco_onout0() {
    document.getElementById( "recc_access_tab0" ).style.backgroundColor = "";
}


function recco_onover1() {
    document.getElementById( "recc_access_tab1" ).style.backgroundColor = "#ff5514";
}
function recco_onout1() {
    document.getElementById( "recc_access_tab1" ).style.backgroundColor = "";
}


function recco_onover2() {
    document.getElementById( "recc_access_tab2" ).style.backgroundColor = "#ff5514";
}
function recco_onout2() {
    document.getElementById( "recc_access_tab2" ).style.backgroundColor = "";
}

function recco_onover3() {
    document.getElementById( "recc_access_tab3" ).style.backgroundColor = "#ff5514";
}
function recco_onout3() {
    document.getElementById( "recc_access_tab3" ).style.backgroundColor = "";
}