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
    yearRange:30,
    firstDay:1,
    autoClose: true,
};
var optionsDatePickerDefault = {
    format: 'yyyy-mm-dd',
    yearRange:30,
    firstDay:1,
    autoClose: true,
};
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, optionsDatePicker);
});

document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepickerDefault');
    var instances = M.Datepicker.init(elems, optionsDatePickerDefault);
});
// Time picker
var optionsTimePicker = {
    twelveHour: false,
    defaultTime: '10:00',
};
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.timepicker');
    var instances = M.Timepicker.init(elems, optionsTimePicker);
});
// Floating button
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems, []);
});

//Chips
var optionsChip = {
    placeholder: 'Enter a tag',
    secondaryPlaceholder: '+ Tag',
    autocompleteOptions: {
        data: {
        }
    },
    onChipAdd: function (e, chip) {
        chip = chip.textContent.replace('close','');
        var data = optionsChip.autocompleteOptions.data;
            if(!data.hasOwnProperty(chip))
                this.deleteChip(-1);

        var chips = document.getElementsByClassName('chip');
        var all = [];

        for(var i=0; i<chips.length; i++){
            all.push(chips[i].firstChild.data);
        }

        document.getElementById('tags').value = JSON.stringify(all);
    }
};
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/tag/json')
        .then(response => {
            optionsChip.autocompleteOptions.data = response.data;
                var elems = document.querySelectorAll('.chips');
                var instances = M.Chips.init(elems, optionsChip);
        });
});

