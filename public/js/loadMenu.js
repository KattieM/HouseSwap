$(document).ready(function(){

    //delete education
    $('.sidenav').off('click').on('click', '.dropdown-btn', function (e) {

        e.stopImmediatePropagation();
        var parent = $(this).attr('id');
        console.log(parent);
        var parent_el = "dropdown-container-"+parent;
        console.log(parent_el+"");
        $.ajax({
            type: 'GET',
            url: '/menu',
            data: {postCode: parent},
            success: function (data) {
                var parentEl = document.getElementById(parent_el);
                console.log(data);
                var el=document.createElement('div');
                el.setAttribute('id', "dropdown_"+parent);
                data.forEach(function(item, index, array){
                    el.innerHTML+=`<a class="link" id=${item.id}>${item.postcode}</a>`;
                });
                $(parentEl).empty();
                $(parentEl).append($(el));
            },
            error: function (data) {
                console.log(data);
            }


        });


    });




});