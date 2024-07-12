$(document).ready(function() {
    // Initialize the calendar
    $('#calendar').fullCalendar({
        editable: true,
        eventClick: function(event) {
            console.log("Event clicked:", event);
            $('#modal-meal-input').val(event.title);
            $('#modal-meal-date').val(moment(event.start).format('YYYY-MM-DD'));
            $('#eventModal').data('event', event).modal('show');
        }
    });

    // Function to schedule a meal
    function scheduleMeal(meal, date) {
        console.log("Scheduling meal:", meal, date);
        $('#calendar').fullCalendar('renderEvent', {
            title: meal,
            start: date,
            allDay: true
        }, true);
    }

    // Function to update a meal
    function updateMeal(event, newTitle, newDate) {
        console.log("Updating meal:", event, newTitle, newDate);
        event.title = newTitle;
        event.start = newDate;
        $('#calendar').fullCalendar('updateEvent', event);
        $('#eventModal').modal('hide');
    }

    // Function to delete a meal
    function deleteMeal(event) {
        console.log("Deleting meal:", event);
        $('#calendar').fullCalendar('removeEvents', event._id);
        $('#eventModal').modal('hide');
    }

    // Event listener for the "Schedule Meal" button
    $('#schedule-meal').click(function() {
        const meal = $('#meal-input').val();
        const date = $('#meal-date').val();
        if (meal && date) {
            scheduleMeal(meal, date);
            $('#meal-input').val('');
            $('#meal-date').val('');
        } else {
            alert('Please enter a meal and select a date.');
        }
    });

    // Event listener for the "Auto Schedule Meal" button
    $('#auto-meal').click(function() {
        const meal = 'Default Meal';  // Default meal name
        const today = moment().format('YYYY-MM-DD');
        scheduleMeal(meal, today);
    });

    // Event listeners for range selection
    $('#daily').click(function() {
        $('#calendar').fullCalendar('changeView', 'agendaDay');
    });

    $('#weekly').click(function() {
        $('#calendar').fullCalendar('changeView', 'agendaWeek');
    });

    $('#monthly').click(function() {
        $('#calendar').fullCalendar('changeView', 'month');
    });

    // Event listener for the "Update Meal" button
    $('#update-meal').click(function() {
        const event = $('#eventModal').data('event');
        console.log("Updating event:", event);
        const newTitle = $('#modal-meal-input').val();
        const newDate = $('#modal-meal-date').val();
        
        if (newTitle && newDate) {
            updateMeal(event, newTitle, newDate);
        } else {
            alert('Please enter a meal and select a date.');
        }
    });

    // Event listener for the "Delete Meal" button
    $('#delete-meal').click(function() {
        const event = $('#eventModal').data('event');
        console.log("Deleting event:", event);
        deleteMeal(event);
    });
});
$(document).ready(function() {
    // Initialize the calendar
    $('#calendar').fullCalendar({
        editable: true,
        eventClick: function(event) {
            console.log("Event clicked:", event);
            $('#modal-meal-input').val(event.title);
            $('#modal-meal-date').val(moment(event.start).format('YYYY-MM-DD'));
            $('#eventModal').data('event', event).modal('show');
        }
    });

    // Function to schedule a meal
    function scheduleMeal(meal, date) {
        console.log("Scheduling meal:", meal, date);
        $('#calendar').fullCalendar('renderEvent', {
            title: meal,
            start: date,
            allDay: true
        }, true);
    }

    // Function to update a meal
    function updateMeal(event, newTitle, newDate) {
        console.log("Updating meal:", event, newTitle, newDate);
        event.title = newTitle;
        event.start = newDate;
        $('#calendar').fullCalendar('updateEvent', event);
        $('#eventModal').modal('hide');
    }

    // Function to delete a meal
    function deleteMeal(event) {
        console.log("Deleting meal:", event);
        $('#calendar').fullCalendar('removeEvents', event._id);
        $('#eventModal').modal('hide');
    }

    // Event listener for the "Schedule Meal" button
    $('#schedule-meal').click(function() {
        const meal = $('#meal-input').val();
        const date = $('#meal-date').val();
        if (meal && date) {
            scheduleMeal(meal, date);
            $('#meal-input').val('');
            $('#meal-date').val('');
        } else {
            alert('Please enter a meal and select a date.');
        }
    });

    // Event listener for the "Auto Schedule Meal" button
    $('#auto-meal').click(function() {
        const meal = 'Default Meal';  // Default meal name
        const today = moment().format('YYYY-MM-DD');
        scheduleMeal(meal, today);
    });

    // Event listeners for range selection
    $('#daily').click(function() {
        $('#calendar').fullCalendar('changeView', 'agendaDay');
    });

    $('#weekly').click(function() {
        $('#calendar').fullCalendar('changeView', 'agendaWeek');
    });

    $('#monthly').click(function() {
        $('#calendar').fullCalendar('changeView', 'month');
    });

    // Event listener for the "Update Meal" button
    $('#update-meal').click(function() {
        const event = $('#eventModal').data('event');
        console.log("Updating event:", event);
        const newTitle = $('#modal-meal-input').val();
        const newDate = $('#modal-meal-date').val();
        
        if (newTitle && newDate) {
            updateMeal(event, newTitle, newDate);
        } else {
            alert('Please enter a meal and select a date.');
        }
    });

    // Event listener for the "Delete Meal" button
    $('#delete-meal').click(function() {
        const event = $('#eventModal').data('event');
        console.log("Deleting event:", event);
        deleteMeal(event);
    });
});

