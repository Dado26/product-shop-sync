import axios from "axios";

$(document).ready(function() {
    $('#check-rules-btn').click(function(){
        if (document.querySelector('#test-url').value == '') return;

        const params = {
            url: document.querySelector('#test-url').value,
            rules: {
                title: document.querySelector('input[name="sync_Rules[title]"]').value,
                description: document.querySelector('input[name="sync_Rules[description]"]').value,
                specifications: document.querySelector('input[name="sync_Rules[specifications]"]').value,
                price: document.querySelector('input[name="sync_Rules[price]"]').value,
                in_stock: document.querySelector('input[name="sync_Rules[in_stock]"]').value,
                in_stock_value: document.querySelector('input[name="sync_Rules[in_stock_value]"]').value,
                price_decimals: document.querySelector('input[name="sync_Rules[price_decimals]"]').value,
                images: document.querySelector('input[name="sync_Rules[images]"]').value,
                variants: document.querySelector('input[name="sync_Rules[variants]"]').value,
            },
        };

        // const params = {
        //     url: 'http://product-sync/test/product',
        //     rules: {
        //         title: '#product-title',
        //         description: '.product-description',
        //         specifications: '#product-specs',
        //         price: '.product-price',
        //         in_stock: '.product-stock',
        //         price_decimals: '2',
        //         images: '.product-images > img',
        //         variants: '.variants > .color',
        //     },
        // };

        // show spinner & hide results
        $('.spinner').parent().show();
        $('#test-rules .results-container').hide();

        // make ajax request
        axios.post('/api/sites/test-rules', params)
            .then(function(response) {
                // show results on success
                $('#test-rules .results-container').show();

                // TITLE
                function getData(item) {
                    if (response.data[item] == null || (response.data[item] && response.data[item].length == 0)) {
                        document.querySelector('#test-rules .form-group.' + item).classList.add('invalid-rule');
                    } else {
                        document.querySelector('#test-rules .form-group.' + item).classList.remove('invalid-rule');
                        document.querySelector('#test-rules .form-group.' + item + ' .form-control').innerText = response.data[item];
                    }
                }

                for (var val in response.data) {
                    console.log(val);
                    getData(val);
                }

                // IMAGES
                if (response.data.images.length > 0) {
                    var productImages = document.querySelector('#test-rules .images-container');
                    productImages.innerHTML = '';
                    response.data.images.forEach(function (image) {
                        var img = document.createElement("img");
                        img.setAttribute('src', image);
                        img.className ='img-fluid w-50';
                        productImages.appendChild(img);
                    });
                } else {
                    document.querySelector('#test-rules .form-group.images').classList.add('invalid-rule');
                }

                // VARIANTS
                if (response.data.variants.length > 0) {
                    var productVariants = document.querySelector('#test-rules .variants-container');
                    productVariants.innerHTML = '';

                    var list = document.createElement("ol");
                    list.setAttribute('class', 'd-block');

                    response.data.variants.forEach(function (variant) {
                        var item = document.createElement("li");
                        item.textContent = variant;
                        list.appendChild(item);
                    });

                    productVariants.appendChild(list);
                } else {
                    document.querySelector('#test-rules .form-group.variants').classList.add('invalid-rule');
                }
            })
            .catch(function(error) {
                // hide results on server error
                $('#test-rules .results-container').hide();

                alert('Whoops, something went wrong...');
                console.error(error);
            })
            .finally(function() {
                // always hide spinner after request has finished
                $('.spinner').parent().hide();
            });
    });
});
