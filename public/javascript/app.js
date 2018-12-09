function responsiveMenu() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
jQuery(document).ready( function() {

    $('.gift-name').click(function(e) {
        console.log('gift - name');
        const giftId = this.dataset.giftId;
        const soloGift = $('.solo_gift[id=gift-' + giftId + ']');
        const soloGiftBody = $('.solo_gift-body[data-gift-id=' + giftId + ']');
        const soloGiftFooter = $('.solo_gift-footer[data-gift-id=' + giftId + ']');
        const editMyGift = $('.editMyGift[data-gift-id=' + giftId + ']');

        if( soloGift.css('display') === 'flex' && soloGiftBody.css('display') === 'none' && soloGiftFooter.css('display') === 'none' && editMyGift.css('display') == 'none') {
            soloGift.css('display', 'block');
            soloGiftFooter.css('display', 'block');
            soloGiftBody.css('display', 'block');
        } else if (soloGift.css('display') === 'block' && soloGiftBody.css('display') === 'block' && soloGiftFooter.css('display') === 'block' && editMyGift.css('display') == 'none') {
            soloGift.css('display', 'flex');
            soloGiftFooter.css('display', 'none');
            soloGiftBody.css('display', 'none');
        } else if (soloGift.css('display') === 'block' && soloGiftBody.css('display') === 'none' && soloGiftFooter.css('display') === 'none' && editMyGift.css('display') === 'block') {
            editMyGift.css('display', 'none');
            soloGiftFooter.css('display', 'block');
            soloGiftBody.css('display', 'block');
        }
        e.stopImmediatePropagation();
    });

    $('.aEditMyGift').click(function(e) {

        console.log('edit - my - gift');
        e.preventDefault();
        const giftId = this.dataset.giftId;
        const soloGift = $('.solo_gift[id=gift-' + giftId + ']');
        const soloGiftBody = $('.solo_gift-body[data-gift-id=' + giftId + ']');
        const soloGiftFooter = $('.solo_gift-footer[data-gift-id=' + giftId + ']');
        const divToEdit = $('.editMyGift[data-gift-id=' + giftId + ']');

        if(soloGift.css('display') === 'block' && soloGiftBody.css('display') === 'block' && soloGiftFooter.css('display') === 'block' && divToEdit.css('display') === 'none') {
            divToEdit.css('display','block !important');
            soloGiftFooter.css('display', 'none');
            soloGiftBody.css('display', 'none');
        } else if (soloGift.css('display') === 'block' && soloGiftBody.css('display') === 'none' && soloGiftFooter.css('display') === 'none' && divToEdit.css('display') === 'block') {
            soloGift.css('display', 'flex');
            divToEdit.css('display', 'none !important');
        } else if(soloGift.css('display') === 'flex' && soloGiftBody.css('display') === 'none' && soloGiftFooter.css('display') === 'none' && divToEdit.css('display') === 'none') {
            soloGift.css('display', 'block');
            divToEdit.css('display','block !important');
        }
        $.ajax({
            type: 'POST',
            url: "{{ path('homepage') }}",
            dataType: "json",
            data: {
                'id' : giftId
            },
            async: true,
            success: function(data) {
                divToEdit.slideToggle(100);
                //divToEdit.css('display', 'block');
                var url = "{{ path('editMyGift',{'id' : 'giftId', 'name' : 'giftName', 'source' : 'giftSource', 'description' : 'giftDescription'}) }}";
                url = url.replace('giftId', data['id']);
                url = url.replace('giftName', data['name']);
                url = url.replace('giftSource', data['source']);
                url = url.replace('giftDescription', data['description']);

                let content = '<form class="form-edit-gift" action="' + url +'" method="GET" >';
                content += '<label for="gift-name" >Nom du cadeau : </label><input type="text" name="gift-name" value="' + data['name'] + '"/>';
                content += '<label for="gift-description"> Description du cadeau :</label><input type="text" name="gift-description" value="' + data['description'] + '"/>';
                content += '<label for="gift-source">Lien vers le cadeau : </label><input type="text" name="gift-source" value="' + data['source'] +'"/>';
                content += '<input type="submit" name="gift-submit" value="Envoyer"/></form>';

                divToEdit.html(content);
            }

        });
        e.stopImmediatePropagation();
        return false;
    });
});