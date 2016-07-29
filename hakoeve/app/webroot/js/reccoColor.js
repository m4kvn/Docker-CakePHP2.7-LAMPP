window.onload = initializeRecco;
function initializeRecco() {
    document.getElementById( "recco_area0" ).onmouseout = recco_onout0;
    document.getElementById( "recco_area0" ).onmouseover = recco_onover0;
    document.getElementById( "recco_area1" ).onmouseout = recco_onout1;
    document.getElementById( "recco_area1" ).onmouseover = recco_onover1;
    document.getElementById( "recco_area2" ).onmouseout = recco_onout2;
    document.getElementById( "recco_area2" ).onmouseover = recco_onover2;
    document.getElementById( "recco_area3" ).onmouseout = recco_onout3;
    document.getElementById( "recco_area3" ).onmouseover = recco_onover3;
    
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