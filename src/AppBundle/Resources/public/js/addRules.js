$('.newRule .addSimple').click(function(e){
    var ruleHtml = $('.newSimpleRule').html();
    $('.editingRuleSection').append('<div class="rule simpleRule">'+ruleHtml+'</div>');
    nbRule();
});

$('.newRule .addMultiple').click(function(e){
    var ruleHtml = $('.newMultipleRule').html();
    $('.editingRuleSection').append('<div class="rule multipleRule">'+ruleHtml+'</div>');
    nbRule();
});

$('.newRule .addSeveralParts').click(function(e){
    var ruleHtml = $('.newSeveralPartsRule').html();
    $('.editingRuleSection').append('<div class="rule severalPartsRule">'+ruleHtml+'</div>');
    nbRule();
});

$('.editingRuleSection').on( "click", ".rule .myClose", function() {
    var e = $(this);
    if(e.data('ruleid') !== 'undefined'){
        var ruleid = e.data('ruleid');
        var deleted = $( "input[name='deletedRules']" );
        deleted.val(deleted.val()+';'+ruleid);
    }
    $(this).parent('div').parent('div.rule').remove();
    nbRule();
});

$('.editingRuleSection').on( "click", ".rule .addFollowingRule", function() {
    var followingRuleHtml = $('.followingRule').html();
    $(followingRuleHtml).insertBefore($(this));
});

function nbRule(){
    var nbRule = $('.editingRuleSection .rule').length;
    if(nbRule > 1){
        $('#nbRule').html(nbRule+' règles');
    }
    else{
        $('#nbRule').html(nbRule+' règle');
    }
}