
document.addEventListener('keydown', function(event) {
    // Press F1 Button
    if (event.keyCode === 112) {
        window.location.href = '/home';
        event.preventDefault();
    } 
    // Press F2 Button
    else if (event.keyCode === 113) {
        window.location.href = '/homeview';
        event.preventDefault();
    }
    // Press F3 Button
    else if (event.keyCode === 114) {
        window.location.href = '/patientaddview';
        event.preventDefault();
    }
    // Press F4 Button
    else if (event.keyCode === 115) {
        window.location.href = '/patient_list_view';
        event.preventDefault();
    }
    // Press F5 Button
    else if (event.keyCode === 116) {
        window.location.href = '/appointmentListView';
        event.preventDefault();
    }
    // Press F6 Button
    else if (event.keyCode === 117) {
        window.location.href = '/waitingList';
        event.preventDefault();
    }
    // Press F7 Button
    else if (event.keyCode === 118) {
        window.location.href = '/finishedList';
        event.preventDefault();
    }
    // Press F8  Button
    else if (event.keyCode === 119) {
        window.location.href = '/medicalTestView';
        event.preventDefault();
    }
    // Press F9 Button
    else if (event.keyCode === 120) {
        window.location.href = '/diagnosticCategoriesListView';
        event.preventDefault();
    }
    // Press F10 Button
    else if (event.keyCode === 121) {
        window.location.href = '/drugsAddView';
        event.preventDefault();
    }
    // Press F12 Button
    else if (event.keyCode === 123) {
        window.location.href = '/drugsListView';
        event.preventDefault();
    }
});