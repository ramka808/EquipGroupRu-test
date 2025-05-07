@if($category)
<li class="breadcrumb-item"><a href="{{ route('category', $category->id) }}">{{ $category->name }}</a></li>

  @include('product.category', ['category' => $category->parentRecursive])
@endif