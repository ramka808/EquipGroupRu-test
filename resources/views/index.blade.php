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
                    <x-category-tree :categories="$categories" />
                </ul>
            </div>
            <div class="col-md-8 mb-4">
                <h5 class="mb-3">Товары</h5>
                <div class="sorting-options">
                    <span class="sorting-label me-2">Сортировать:</span>
                    <div class="btn-group mb-2" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">По цене ⬆️</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">По цене ⬇️</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">По названию ⬆️</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">По названию ⬇️</button>
                    </div>
                </div>
                @if ($products->isNotEmpty())
                    <ul class="list-group">
                        @foreach ($products as $product)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="#" class="text-decoration-none">
                                            {{ $product->name }}
                                        </a>
                                        
                                    </div>
                                    <span class="">{{ $product->price->price }} руб.</span>
                                    

                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
