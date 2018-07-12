$('.editingRuleSection').on( "click", ".rule .insertJ1", function() {
    var img = $('.imgForInsertion .j1Img').clone();
    var textarea = $(this).parent('div').next('div.contentEditable');
    clearBr(textarea);
    textarea.append(img);
});

$('.editingRuleSection').on( "click", ".rule .insertJ2", function() {
    var img = $('.imgForInsertion .j2Img').clone();
    var textarea = $(this).parent('div').next('div.contentEditable');
    clearBr(textarea);
    textarea.append(img);
});

$('.editingRuleSection').on( "click", ".rule .insertJ3", function() {
    var img = $('.imgForInsertion .j3Img').clone();
    var textarea = $(this).parent('div').next('div.contentEditable');
    clearBr(textarea);
    textarea.append(img);
});

$('.editingRuleSection').on( "click", ".rule .insertJ4", function() {
    var img = $('.imgForInsertion .j4Img').clone();
    var textarea = $(this).parent('div').next('div.contentEditable');
    clearBr(textarea);
    textarea.append(img);
});

$('.editingRuleSection').on( "click", ".rule .insertT1", function() {
    var img = $('.imgForInsertion .t1Img').clone();
    var textarea = $(this).parent('div').next('div.contentEditable');
    clearBr(textarea);
    textarea.append(img);
});

$('.editingRuleSection').on( "click", ".rule .insertT2", function() {
    var img = $('.imgForInsertion .t2Img').clone();
    var textarea = $(this).parent('div').next('div.contentEditable');
    clearBr(textarea);
    textarea.append(img);
});

function clearBr(textarea){
    content = textarea.html();
    content = content.replace(new RegExp('<br>', 'g'), '')
    textarea.html(content);
}