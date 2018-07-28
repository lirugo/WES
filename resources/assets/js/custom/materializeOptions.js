// Init Left navigation
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, []);
});
// Init Collapse
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, []);
});
// Init Select
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, []);
});
// Tooltip
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems, []);
});
// DatePicker
var optionsDatePicker = {
    format: 'yyyy-mm-dd',
    minDate: new Date(1940, 0, 1),
    maxDate: new Date(),
    defaultDate: new Date(1980, 0, 1),
    yearRange:30
};
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, optionsDatePicker);
});