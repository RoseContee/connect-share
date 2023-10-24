function imagePreview (files, $imgElem, defaultImage) {
    if (!files.length) {
        $imgElem.attr('src', defaultImage);
        return;
    }
    const fr = new FileReader();
    fr.onload = () => {
        $imgElem.attr('src', fr.result);
    };
    fr.readAsDataURL(files[0]);
}

function showFullLoading() {
    $('#full-loading').show();
}

function hideFullLoading() {
    $('#full-loading').hide();
}

function getCookie(cname) {
    let name = cname + '=';
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return '';
}
