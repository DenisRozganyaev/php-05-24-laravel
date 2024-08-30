const selectors = {
    wrapper: "#images-wrapper",
    item: ".images-wrapper-item",
    removeBtn: ".images-wrapper-item-remove",
    addBtn: ".add-images",
    input: "#images",
    spinner: "#spinner"
};

const template = `
<div class='mb-4 col-md-6 images-wrapper-item'>
    <button class="btn btn-danger images-wrapper-item-remove"
        data-url="/ajax/images/_id_">
        <i class="fa-solid fa-minus"></i>
    </button>
    <img src='_url_' style='width: 100%' />
</div>
`

$(document).ready(function () {
    $(selectors.addBtn).on('click', function (e) {
        e.preventDefault();
        $(selectors.input).click();
    });

    $(selectors.input).on('change', function(e) {
        e.preventDefault();
        const uploadUrl = $(selectors.addBtn).data('upload');
        const formData = new FormData();

        $(selectors.spinner).removeClass('d-none');
        $(selectors.addBtn).addClass('disabled');

        for(let i = 0; i < this.files.length; i++) {
            formData.append(`images[${i}]`, this.files[i], this.files[i].name);
        }

        axios.post(
            uploadUrl,
            formData,
            {
                headers: { "Content-Type": "multipart/form-data" }
            }
        ).then((response) => {

        }).catch((error) => {

        })
    });

    $(selectors.removeBtn).on('click', function (e) {
        e.preventDefault();

        const $btn = $(this);

        $btn.addClass('disabled');

        axios.delete(
            $btn.data('url'),
            {
                responseType: 'json'
            }
        ).then((response) => {
            iziToast.success({
                message: response.data.message,
                position: 'topRight'
            });
            $btn.parent().remove();
        }).catch((error) => {
            console.error(error);
            iziToast.warning({
                message: error.data.message,
                position: 'topRight'
            });
            $btn.removeClass('disabled');
        })
    })
});
