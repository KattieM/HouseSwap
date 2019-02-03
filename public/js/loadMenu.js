$(document).ready(function(){

    //Return elements of navbar
    $('.sidenav').off('click').on('click', '.dropdown-btn', function (e) {
        e.stopImmediatePropagation();
        var parent = $(this).attr('id');
        var parent_el = "dropdown-container-"+parent;
        $.ajax({
            type: 'GET',
            url: '/menu',
            data: {postCode: parent},
            success: function (data) {
                var parentEl = document.getElementById(parent_el);
                var el=document.createElement('div');
                el.setAttribute('id', "dropdown_"+parent);
                data.forEach(function(item, index, array){
                    el.innerHTML+=`<a class="link" id=${item.id} data-long=${item.longitude} data-lat=${item.latitude}>${item.postcode}</a>`;
                });
                $(parentEl).empty();
                $(parentEl).append($(el));
            },
            error: function (data) {
            }
        });

    });

    //Return data for table
    $('.dropdown-container').off('click').on('click', '.link', function (e) {
        e.stopImmediatePropagation();
        var parent = $(this).attr('id');
        var long = $(this).attr('data-long');
        var lat = $(this).attr('data-lat')
        console.log(parent);
        $.ajax({
            type: 'GET',
            url: '/data',
            data: {postcode_id: parent, longitude:long, latitude:lat},
            success: function (data) {
               console.log(data);
                var el=document.createElement('div');
                el.setAttribute('class', "table-data");
                $.each( data.busstops, function( key, value ) {
                    el.innerHTML+=`<p class="link"}>${value.name}</p>`;
                });
                $('#busstops').empty();
               $('#busstops').append($(el));

                var el2=document.createElement('div');
                el2.setAttribute('class', "table-data");
                $.each( data.schools, function( key, value ) {
                    el2.innerHTML+=`<p class="link"}>${value.name}</p>`;
                });
                $('#schools').empty();
                $('#schools').append($(el2));
                var el3=document.createElement('div');
                el3.setAttribute('class', "table-data");
                $.each( data.addresses, function( key, value ) {
                    el3.innerHTML+=`<p class="link"}>${value.street}</p>`;
                });
                $('#addresses').empty();
                $('#addresses').append($(el3));
            },
            error: function (data) {
                console.log(data);
            }
        });

    });

});