function convertToSlug(source_id, target_id) {
    let text = document.getElementById(source_id).value;
    let slug = text.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById(target_id).value = slug;
}

function copy_value(source_id, destination_id) {
    document.getElementById(destination_id).value = document.getElementById(source_id).value;
}

function imgPreview(event, container_id) {
    var output = document.getElementById(container_id);
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
    }
};

function reload() {
    window.location = window.location.href.split("?")[0];
}

function refresh() {
    window.location = window.location.href;
}

function goto(url) {
    window.location = url;
}

function submitOnEnter(buttonId, e) {
    e = e || window.event;
    if (e.keyCode == 13) // enter key
    {
        document.getElementById(buttonId).click();
        return false;
    }
    return true;
}

function generateSlug(source_id, target_id) {
    var a = document.getElementById(source_id).value;
    var b = a.toLowerCase().replace(/ /g, '-')
        .replace(/[^\w-]+/g, '');
    document.getElementById(target_id).value = b;
}


