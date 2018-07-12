$('.newDeck form').submit(function(event) {

    event.preventDefault();

    $('.simpleRule').each(function(index) {
        var simpleRule = $(this);
        var contentHtml = simpleRule.find('div.contentEditable').html();

        simpleRule.find('textarea').text(contentHtml);
    });

    $('.multipleRule').each(function(index) {
        var multipleRule = $(this);
        var contentsEditable = multipleRule.find('div.contentEditable');
        var contentHtml = '';

        contentsEditable.each(function(index) {
            contentHtml += '&$&$&'+$(this).html();
        });

        multipleRule.find('textarea').text(contentHtml);
    });

    $('.severalPartsRule').each(function(index) {
        var severalPartsRule = $(this);
        var contentsEditable = severalPartsRule.find('div.contentEditable');
        var contentHtml = '';

        contentsEditable.each(function(index) {
            contentHtml += '&$&$&'+$(this).html();
        });

        severalPartsRule.find('textarea').text(contentHtml);
    });


    $(this).unbind('submit').submit(); 
});
