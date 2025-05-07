<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Shop</title>
</head>

<body class="bg-light">


    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="">Категории</h5>
                <ul class="list-unstyled">
                    <li class="list-group-item">
                        <div class="d-flex align-items-center">
                            <a href="/" class="category-link flex-grow-1 text-decoration-none text-center mb-2"
                                data-bs-toggle="" data-category-id="0">
                                <i class="bi bi-chevron-right me-2 "></i>
                                <h5 class="d-inline">Все товары</h5>
                                @php
                                    $totalProducts = 0;
                                    foreach ($categories as $category) {
                                        $totalProducts += $category->allProducts()->count();
                                    }
                                @endphp
                                <span class="badge bg-secondary">{{ $totalProducts }}</span>
                            </a>
                        </div>
                        {{-- Рекурсивный вывод категорий --}}
                        <x-category-tree :categories="$categories" />
                </ul>
            </div>
            <div class="col-md-8 mb-4">
                <h5 class="mb-3">Товары</h5>

                <div class="buttouns-option ">
                    <span class="sorting-label me-2">Сортировать:</span>
                    <div class="btn-group mb-2 sorting-options" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-sort="price_asc">По цене
                            ⬆️</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-sort="price_desc">По цене
                            ⬇️</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-sort="name_asc">По названию
                            ⬆️</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-sort="name_desc">По
                            названию ⬇️</button>

                    </div>
                    <span class="products-per-page-label">Показать:</span>
                    <div class="btn-group mb-2 products-per-page" role="group2">
                        <button type="button" class="btn btn-sm btn-outline-secondary active" data-page="6">6</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-page="12">12</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-page="18">18</button>
                    </div>
                </div>


                <div class="product-list-container ">

                </div>
                <div class="pagination-container mt-3">
                    <nav aria-label="pagination">
                        <ul class="pagination">

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const myApp = {
        currentCategoryId: {{ $categoryId ?? 0 }},
        sortby: '',
        perPage: 6
    };

    document.addEventListener('DOMContentLoaded', async function() {
        const productListContainer = document.querySelector('.product-list-container');
        console.log('productListContainer:', productListContainer);

        await fetchAndDisplayProducts(myApp.currentCategoryId, 1, myApp.sortby, myApp.perPage);

        document.querySelectorAll('.category-link').forEach(link => {
            link.addEventListener('click', async function(e) {

                e.preventDefault();

                myApp.currentCategoryId = this.dataset.categoryId;
                console.log('Selected category ID:', myApp.currentCategoryId);

                await fetchAndDisplayProducts(myApp.currentCategoryId, 1, myApp.sortby,
                    myApp.perPage);
            });
        });

        //Сортировка
        document.querySelectorAll('.sorting-options button').forEach(button => {
            button.addEventListener('click', async function() {
                document.querySelectorAll('.sorting-options button').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                myApp.sortby = this.dataset.sort;
                await fetchAndDisplayProducts(myApp.currentCategoryId, 1, myApp.sortby,
                    myApp.perPage);
            });
        });

        //Колво товара на странице
        document.querySelectorAll('.products-per-page button').forEach(button => {
            button.addEventListener('click', async function() {

                document.querySelectorAll('.products-per-page button').forEach(btn => {
                    btn.classList.remove('active');
                });


                this.classList.add('active');

                myApp.perPage = this.dataset.page;
                await fetchAndDisplayProducts(myApp.currentCategoryId, 1, myApp.sortby,
                    myApp.perPage);
            });
        });

        //Получение и вывод товров
        async function fetchAndDisplayProducts(categoryId, page = 1, sortOrder = '', perPage) {
            try {
                const response = await fetch(
                    `/api/category/${categoryId}/products?page=${page}&sort=${sortOrder}&perPage=${perPage}`, {
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        method: 'GET',
                    });

                if (!response.ok) {
                    throw new Error('Ошибка сети: ' + response.status);
                }

                const data = await response.json();
                console.log('Успех:', data);
                productListContainer.innerHTML = '';
                if (Array.isArray(data.data) && data.data.length > 0) {
                    const ul = document.createElement('ul');
                    ul.className = 'list-group';

                    data.data.forEach(product => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.innerHTML = `
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="/product/${product.id}" class="text-decoration-none">
                                        ${product.name}
                                    </a>
                                </div>
                                <span class="">${product.price.price} руб.</span>
                            </div>
                        `;

                        ul.appendChild(li);
                    });

                    productListContainer.appendChild(ul);


                    addPagination(data);
                } else {
                    productListContainer.innerHTML = '<p>Нет доступных товаров.</p>';
                }
            } catch (error) {
                console.error('Ошибка:', error);
            }
        }
        //кнопки пагинации
        function addPagination(data) {
            console.log('addPagination:', data);
            const ulPagination = document.querySelector(
                'ul.pagination');
            ulPagination.innerHTML = '';

            const prevItem = document.createElement('li');
            prevItem.className = 'page-item' + (data.current_page === 1 ? ' disabled' : '');
            prevItem.innerHTML = `<a class="page-link" href="#">Предыдущая</a>`;
            prevItem.onclick = () => fetchAndDisplayProducts(myApp.currentCategoryId, data.current_page -
                1, myApp.sortb, myApp.perPage);
            ulPagination.appendChild(prevItem);


            const maxPagesToShow = 8;
            let startPage, endPage;

            if (data.last_page <= maxPagesToShow) {

                startPage = 1;
                endPage = data.last_page;
            } else {

                startPage = Math.max(1, data.current_page - Math.floor(maxPagesToShow / 2));
                endPage = Math.min(data.last_page, startPage + maxPagesToShow - 1);


                if (endPage === data.last_page) {
                    startPage = Math.max(1, endPage - maxPagesToShow + 1);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                const li = document.createElement('li');
                li.className = 'page-item' + (data.current_page === i ? ' active' : '');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.onclick = () => fetchAndDisplayProducts(myApp.currentCategoryId,
                    i, myApp.sortby, myApp.perPage);
                ulPagination.appendChild(li);
            }

            if (data.last_page > endPage) {
                const dots = document.createElement('li');
                dots.className = 'page-item';
                dots.innerHTML = `<a class="page-link" href="#">...</a>`;
                ulPagination.appendChild(dots);
                const lastPageItem = document.createElement('li');
                lastPageItem.className = 'page-item';
                lastPageItem.innerHTML = `<a class="page-link" href="#">${data.last_page}</a>`;
                lastPageItem.onclick = () => fetchAndDisplayProducts(myApp.currentCategoryId, data
                    .last_page, myApp.sortby, myApp.perPage);
                ulPagination.appendChild(lastPageItem)
            }

            const nextItem = document.createElement('li');
            nextItem.className = 'page-item' + (data.current_page === data.last_page ? ' disabled' : '');
            nextItem.innerHTML = `<a class="page-link" href="#">Следующая</a>`;
            nextItem.onclick = () => fetchAndDisplayProducts(myApp.currentCategoryId, data.current_page +
                1, myApp.sortby, myApp.perPage);
            ulPagination.appendChild(nextItem);


        }
    });
</script>

</html>
