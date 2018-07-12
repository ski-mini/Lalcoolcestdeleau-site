$('.newDeck').on( "click", ".clickToEdit", function() {
    var e = $(this);
    var ruleid = e.data('ruleid');
    e.find('button').removeAttr('disabled');
    e.find('.hide').removeClass('hide');
    e.find('.contentEditable').attr('contentEditable', 'true');
    e.removeClass('clickToEdit');
    var updated = $( "input[name='updatedRules']" );
    var deleted = $( "input[name='deletedRules']" );
    updated.val(updated.val()+';'+ruleid);
});

$('.newDeck').ready(function() {
    nbRule();
});

$('.setModeToUpdate').click(function(){
    $('input[name="mode"]').val('update');
    $('button.setModeToNew').click();
});