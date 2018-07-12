$(".newDeck select[name='deckType']").change(function(e){
    //foutre une alerte genre "attention y'a pu de j3/j4"
    if($(this).val() == '1'){
        $('.newDeck .insertT1').html('Joueur1').removeClass('insertT1').addClass('insertJ1');
        $('.newDeck .insertT2').html('Joueur2').removeClass('insertT2').addClass('insertJ2');
        $('.newDeck .insertJ3').removeClass('hide');
        $('.newDeck .insertJ4').removeClass('hide');

        var img1 = $('.imgForInsertion .j1Img').clone();
        var img2 = $('.imgForInsertion .j2Img').clone();

        $('.newDeck .rule .t1Img').replaceWith(img1);
        $('.newDeck .rule .t2Img').replaceWith(img2);
    }
    else if($(this).val() == '2'){
        $('.newDeck .insertJ1').html('Equipe1').removeClass('insertJ1').addClass('insertT1');
        $('.newDeck .insertJ2').html('Equipe2').removeClass('insertJ2').addClass('insertT2');
        $('.newDeck .insertJ3').addClass('hide');
        $('.newDeck .insertJ4').addClass('hide');

        var img1 = $('.imgForInsertion .t1Img').clone();
        var img2 = $('.imgForInsertion .t2Img').clone();

        $('.newDeck .rule .j1Img').replaceWith(img1);
        $('.newDeck .rule .j2Img').replaceWith(img2);
        $('.newDeck .rule .j3Img').remove();
        $('.newDeck .rule .j4Img').remove();
    }
}); 