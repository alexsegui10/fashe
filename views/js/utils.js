function ajaxpromise(stype, surl, sdata, sdatatype){
    console.log(stype, surl, sdata, sdatatype);
    return new Promise((resolve, reject) => {
    $.ajax({
        type: stype,
        url: surl,
        data: sdata,
        dataType: sdatatype
        }).done((data) => {
            alert("si");
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            alert("no");
            reject(errorThrow);
        }); 
    });
}
