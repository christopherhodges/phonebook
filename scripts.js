
// Click to remove a person
$('#list').on('click', '[href="#del"]', function(e){

    e.preventDefault();

    // Remove person
    removePerson( $(this).parents('.person').attr('data-id') );

});



// Form Submission
$('form').submit(function(e){

    // PRevent Default
    e.preventDefault();

    // Validate
    var valid = validateForm();

    if ( valid ) {

        // Get vals
        var first = $(this).find('[name="first_name"]').val();
        var last  = $(this).find('[name="last_name"]').val();
        var phone = $(this).find('[name="phone_number"]').val();

        // Add a new person
        addPerson(first, last, phone);

    }


})


// Fade In Modal
function showModal(){

    //reset
    $('#modal').removeClass('loading');
    $('#modal [name="first_name"]').val('');
    $('#modal [name="last_name"]').val('');
    $('#modal [name="phone_number"]').val('');

    // fase in
    $('#cover').fadeIn(function(){
        $('#modal').fadeIn();
    });

}


// Fade out mdoal
function hideModal(){

    //reset
    $('#modal [name="first_name"]').val('');
    $('#modal [name="last_name"]').val('');
    $('#modal [name="phone_number"]').val('');

    $('#modal').fadeOut(function(){
        $('#cover').fadeOut();
    });

}

function validateForm(){
    var valid = true;
    $('#modal input').each(function(){

        var type = $(this).attr('type');
        switch ( type ){
            case 'text':
                if ( $(this).val() != '' ) {
                    $(this).removeClass('error');
                } else {
                    $(this).addClass('error');
                    valid = false;
                }
                break;
            case 'tel':
                    var pttrn = /[0-9 -()+]+$/;
                    if ( $(this).val() < 6 || !pttrn.test($(this).val())  ) {
                        $(this).addClass('error');
                        valid = false;
                    } else {
                        $(this).removeClass('error');
                    }
                    break;
            default:
                break;

        }
    });

    return valid;


}

function addPerson( first, last, phone ){

    $('#modal').addClass('loading');

    $.ajax({
        type: "POST",
        data : {
                'action' : 'phonebook_add_person',
                'first'  : first,
                'last'   : last,
                'phone'  : phone
               },
        url: localized_vars.ajax_url,
        success: function( response ){

            // Hide the modal
            hideModal();

            // clone the template
            var new_person = $('.template').clone();

            // add content
            $(new_person).find('.name').text( last + ', ' + first );
            $(new_person).find('.phone_number').text(phone);
            $(new_person).attr('data-name', last + ', ' + first );
            $(new_person).attr('data-id', response);

            // append the template
            $('#list').append($(new_person));

            // reveal the new_person
            $(new_person).removeClass('template');

            // and sort
            sortPeople();
        },
        done: function(){
            $('#modal').removeClass('loading');
        }
    })
}

function removePerson( id ){
    $.ajax({
        type: "POST",
        data : {
                'action' : 'phonebook_remove_person',
                'id'  : id
               },
        url: localized_vars.ajax_url,
        success: function( response ){

            var person = $('[data-id="'+ id + '"]');

            // add class to animate removal
            person.addClass('remove');

            // Remove from dom
            setTimeout(function(){ person.remove() }, 1000);

        }
    })
}

function sortPeople(){
    var mylist = $('#list');
    var listitems = mylist.children('.person').get();
    listitems.sort(function(a, b) {
       return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
    })
    $.each(listitems, function(idx, itm) { mylist.append(itm); });
}

// Click to add a new person
$('[href="#add"]').click(function(e){
    e.preventDefault();
    showModal();
})


// Click to remove modal
$('[type="reset"]').click(function(){
    hideModal();
})
