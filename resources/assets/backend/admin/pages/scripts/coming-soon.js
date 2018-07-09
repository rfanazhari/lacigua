function adddays(thedate, days) {
    return new Date(thedate.getTime() + days*24*60*60*1000);
}

var ComingSoon = function () {
    return {
        init: function () {
        	var thedate = new Date($('#thedate').val() * 1000);
            var expired = adddays(thedate, $('#numberofdays').val());
            expired = new Date(expired.getFullYear(), expired.getMonth(), expired.getDate());
            $('#defaultCountdown').countdown({until: expired});
            $('#year').text(expired.getFullYear());
        }
    };
}();