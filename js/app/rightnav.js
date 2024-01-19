$(document).ready(function(){
    getOpenTabForSearchScreen();
    setOpenTabForSearchScreen();
})

function getOpenTabForSearchScreen() {
    $value = $('#get_open_tab_for_search_screens').val();
    setCheckedValues($('#open_tab_for_search_screens_1'), $value, 1);
}

function setOpenTabForSearchScreen(){

    $(document).on("change", ".open_tab_for_search_screens", function(){

        if ($(this).is(':checked')) {
            $open_tab_for_search_screens = 1;
        }else{ 
            $open_tab_for_search_screens = 0;
        }

        $url = $('#route_update_single_app_setting').val();
        $.ajax({
            url: $url,
            data: { 
                open_tab_for_search_screens: $open_tab_for_search_screens,
                _token: csrf_token()
            },
            method: 'GET',
            dataType: 'json',
            success: function ($result) {
                // getOpenTabForSearchScreen();
            }
        });

    })

}


