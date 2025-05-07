<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <!-- Хлебные крошки -->
            {{-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('idnex') }}">Главная</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category', $product->category_id) }}">Категория</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav> --}}


            
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
            @include('product.category', ['category' => $parentCategories->first()])
            <li class="breadcrumb-item"><a href="{{ route('idnex') }}">Главная</a></li>
        </ol>
        </nav> 
            {{-- @foreach($parentCategories as $category) --}}
                {{-- @foreach($category as $category2) --}}
                {{-- {{$category2}} --}}
                
                    {{-- @include('product.category', ['category' => $category]) --}}
                {{-- @endforeach --}}
           {{-- @endforeach --}}
        <!-- Карточка товара -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">Цена: {{ $product->price->price }} руб.</p>
                
                
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const list = document.querySelector('ol.breadcrumb');
            
            if (list) {
                console.log('list:', list);
                const items = Array.from(list.getElementsByTagName('li'));
                items.reverse();

                // Очищаем список
                list.innerHTML = '';

                // Добавляем перевернутые элементы обратно в список
                items.forEach(item => {
                    list.appendChild(item);
                });
            } else {
                console.error('Элемент <ol class="breadcrumb"> не найден.');
            }
        });
    </script>
</body>
</html>