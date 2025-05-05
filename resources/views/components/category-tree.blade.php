{{-- <div>
    <ul>
        @foreach($categories as $category)
            <li>
                {{ $category->name }}
                @if($category->children->isNotEmpty())
                    <x-category-tree :categories="$category->children" />
                @endif
            </li>
        @endforeach
    </ul>
</div> --}}

 
<ul class="list-group list-group-flush">
    @foreach($categories as $category)
        <li class="list-group-item">
            <div class="d-flex align-items-center">
                @if($category->children->isNotEmpty())
                    <a href="#category-{{ $category->id }}" 
                       class="category-link flex-grow-1 text-decoration-none"
                       data-bs-toggle="collapse"
                       data-category-id="{{ $category->id }}">
                        <i class="bi bi-chevron-right me-2"></i>
                        {{ $category->name }}
                        <span class="badge bg-secondary">{{ $category->allProducts()->count() }}</span>
                    </a>
                @else
                    <a href="{{route('category', $category->id)}}"
                       class="category-link flex-grow-1 text-decoration-none"
                       data-category-id="{{ $category->id }}">
                        <span class="ms-4">{{ $category->name }}</span>
                        <span class="badge bg-secondary">{{ $category->allProducts()->count() }}</span>
                    </a>
                @endif
            </div>

            @if($category->children->isNotEmpty())
                <div class="collapse ps-3" id="category-{{ $category->id }}">
                    <x-category-tree :categories="$category->children" />
                </div>
            @endif
        </li>
    @endforeach
</ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.category-link').forEach(link => {
        link.addEventListener('click', function(e) {
          
            if(this.getAttribute('href') === '#') {
                e.preventDefault();
            }
            
            const categoryId = this.dataset.categoryId;
            console.log('Selected category ID:', categoryId);
            
           
            
           
            document.querySelectorAll('.category-link').forEach(el => {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});
</script>

<style>
.category-link.active {
    font-weight: bold;
    color: #0d6efd;
}

.badge {
    margin-left: 5px;
    font-size: 0.8em;
}
</style>