const selectors = {
    thumbnail: {
        input: '#thumbnail',
        preview: '#thumbnail-preview'
    },
    gallery: {
        input: '#images',
        wrapper: '#images-wrapper'
    }
};

$(document).ready(function() {
    if (window.FileReader) {
        $(selectors.gallery.input).on('change', function() {
            let counter = 0, file;
            const template = "<div class='mb-4 col-md-6'><img src='_url_' style='width: 100%' /></div>";

            $(selectors.gallery.wrapper).html('');

            while(file = this.files[counter++]) {
                const reader = new FileReader();
                reader.onloadend = (() => {
                    return (e) => {
                        const img = template.replace('_url_', e.target.result)
                        $(selectors.gallery.wrapper).append(img)
                    }
                })(file)
                reader.readAsDataURL(file)
            }
        })

        $(selectors.thumbnail.input).on('change', function() {
            const reader = new FileReader();
            reader.onloadend = (e) => {
                $(selectors.thumbnail.preview).attr('src', e.target.result).show()
            }
            reader.readAsDataURL(this.files[0])
        })
    }
});
