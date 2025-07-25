function allocationChannel(e, user_id, user_role) {
    if (user_role != 'admin') {
        if (e.allocation.lecturer.user.id == user_id) {
            $.notify('New Schedule allocated !'
                + e.allocation.schedule.id + " "
                + e.allocation.schedule.course_code + " "
                + e.allocation.schedule.ac_name
                + " To " + e.allocation.lecturer.name
                , {
                    autoHideDelay: 50000,
                    className: "success"
                });
        }
    } else {
        $.notify('New Schedule allocated !'
            + e.allocation.schedule.id + " "
            + e.allocation.schedule.course_code + " "
            + e.allocation.schedule.ac_name
            + " To " + e.allocation.lecturer.name
            , {
                autoHideDelay: 50000,
                className: "success"
            });
    }
}

function cancelChannel(e, user_id, user_role) {
    if (user_role == 'admin') {

        $("#cancellationCount").html(e.cancellationCount);
        $.notify('New Cancellation Request !' + e.allocationCancellation.allocation.schedule.id + " "
            + e.allocationCancellation.allocation.schedule.course_code + " "
            + e.allocationCancellation.allocation.schedule.ac_name
            + " By " + e.allocationCancellation.lecturer.name
            , {
                autoHideDelay: 50000,
                className: "danger"
            });
    }

}

function approveChannel(e, user_id, user_role) {
    if (user_role != 'admin') {

        $("#cancellationCount").html(e.cancellationCount);
        $.notify('Cancellation Approved !' + e.allocationCancellation.allocation.schedule.id + " "
            + e.allocationCancellation.allocation.schedule.course_code + " "
            + e.allocationCancellation.allocation.schedule.ac_name
            + " By " + e.allocationCancellation.lecturer.name
            , {
                autoHideDelay: 50000,
                className: "danger"
            });
    }
}

//date validation
function isValidDate(dateString,opt) {
    if(opt) {
        if (opt['empty'] == true) {
            if (dateString == '') return true;
        }
    }
    dateString = String(dateString);
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    if (!(dateString.match(regEx))) return false;  // Invalid format
    var d = new Date(dateString);
    var dNum = d.getTime();
    if (!dNum && dNum !== 0) return false; // NaN value, Invalid date
    return d.toISOString().slice(0, 10) === dateString;
}
//is valid time
function isValidTime(value) {
    if(value=='')return true;
    if (!/^\d{2}:\d{2}([:]\d{0,2}\b|)$/.test(value)) return false;
    var parts = value.split(':');
    parts[0] = parts[0].padStart(2, "0")
    parts[1] = parts[1].padStart(2, "0")
    parts[2] ? (parts[2] = parts[2].padStart(2, "0")) : parts[2] = "00";
    value = parts[0] + ':' + parts[1] + ':' + parts[2];
    parts = value.split(':');

    if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59) return false;
    return true;
}

//is valid time
function timeFormat(value) {
    if(value=='')return'';
    value = replaceAll(value, '.', ':');
    //console.log(value);
    var parts = value.split(':');
    parts[0] ? (parts[0] = parts[0].padStart(2, "0")) : parts[0] = "00";
    parts[1] ? (parts[1] = parts[1].padStart(2, "0")) : parts[1] = "00";
    parts[2] ? (parts[2] = parts[2].padStart(2, "0")) : parts[2] = "00";
    value = parts[0] + ':' + parts[1] + ':' + parts[2];

    if (!/^\d{2}:\d{2}([:]\d{0,2}\b|)$/.test(value)) return false;
    //if (!/^\d{2}:\d{2}:\d{2}$/.test(value)) return false;
    parts = value.split(':');
    if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59) return false;
    return value;
}

//temperature validation
function isValidTemp(value) {
    if (!/^[+-]?\d+(\.\d+)?$|^U\/T$|^U\/R$/.test(value)) return false;
}

//temperature formatting
function tempFormat(value) {
    //value = String(value);
    var float = value.match(/^[+-]?\d+(\.\d+)?$/);
    var unit = value.match(/^U\/T$|^U\/R$/);

    if(/^[+-]?\d+(\.\d+)?$/.test(value)) {
        return parseFloat(Math.round(parseFloat(float[0]) * 100) / 100).toFixed(2);
    }else if(/^U\/T$|^U\/R$/.test(value)){
        return unit[0].toUpperCase();
    }else if(value.toUpperCase()=="T"||value.toUpperCase()=="UT"||value.toUpperCase()=="U/T"){
        return "U/T";//unit tripping
    }else if(value.toUpperCase()=="R"||value.toUpperCase()=="UR"||value.toUpperCase()=="U/R"){
        return "U/R";//unit repair
    }else if(value.toUpperCase()=="W"||value.toUpperCase()=="BW"||value.toUpperCase()=="B/W"){
        return "B/W";//Bad Weather
    }else if(value.toUpperCase()=="WD"||value.toUpperCase()=="W/D"){
        return "W/D";//Water Damage
    }else if(value.toUpperCase()=="FD"||value.toUpperCase()=="F/D"){
        return "F/D";//Fire Damage
    }else if(value.toUpperCase()=="DD"||value.toUpperCase()=="D/D"){
        return "D/D";//Door Damage
    }else if(value.toUpperCase()=="TD"||value.toUpperCase()=="T/D"){
        return "T/D";//Temperature Deviation
    }else if(value.toUpperCase()=="OTH"||value.toUpperCase()=="O"){
        return "OTH";//Other
    }else if(value.toUpperCase()=="EOFF"||value.toUpperCase()=="EO"){
        return "EOFF";//Excessive Time Off-Power
    }else if(value.toUpperCase()=="CND"||value.toUpperCase()=="CN"){
        return "CND";//Condensation
    }else{
        return "";
    }

}

function replaceAll(string, search, replacement) {
    var target = string;
    return target.split(search).join(replacement);
};

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});
